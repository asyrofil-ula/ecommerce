<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $startDate = request('start_date') ? Carbon::parse(request('start_date')) : Carbon::now()->startOfMonth();
        $endDate = request('end_date') ? Carbon::parse(request('end_date')) : Carbon::now()->endOfMonth();

        $users = User::take(5)->get();
        $totalSales = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $totalCustomers = User::whereHas('orders')->count();
        $totalProducts = Product::count();
        $totalRevenue = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total_price');
        $totalUsers = User::count();

    return view('admin.dashboard', [
        'users' => $users,
        'totalSales' => $totalSales,
        'totalCustomers' => $totalCustomers,
        'totalProducts' => $totalProducts,
        'totalRevenue' => $totalRevenue,
        'totalUsers' => $totalUsers,

    ]);
    }

    public function users()
    {
        $search = request('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->orderBy('created_at', 'asc')
            ->paginate(5)

            ->appends(['search' => $search]);
        return view('admin.users')->with('users', $users);
    }

    public function report(Request $request)
    {
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()->endOfMonth()));

        $orderDetails = OrderDetail::with('product', 'order')
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'Completed'); // Filter hanya untuk status "Completed"
            })
            ->get();

        // Total Penjualan
        $totalSales = $orderDetails->sum(function ($orderDetail) {
            return $orderDetail->quantity * $orderDetail->price;
        });

        // Total Produk Terjual
        $totalProductsSold = $orderDetails->sum('quantity');

        // Total Penjualan per Produk
        $productsSales = $orderDetails->groupBy('product_id')->map(function ($items) {
            return $items->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
        });
        $productIds = $productsSales->keys();
        $products = Product::whereIn('id', $productIds)->get();

        return view('admin.report', compact(
            'orderDetails',
            'totalSales',
            'totalProductsSold',
            'productsSales',
            'startDate',
            'endDate',
            'products'
        ));
    }
}
