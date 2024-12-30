<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $orders = Order::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('address', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5)
            ->appends(['search' => $search]); // Menambahkan query search pada pagination link
        return view('admin.orders')->with('orders', $orders);
    }

    public function userOrders()
    {
        $user = auth()->user(); // Ambil pengguna yang sedang login
        $orders = $user->orders()->orderBy('created_at', 'desc')->get(); // Ambil semua pesanan pengguna

        return view('user.orders', compact('orders'));
    }

    public function orderSuccess($id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya pengguna terkait yang bisa melihat order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('user.order.success', compact('order'));
    }

    public function orderPending($id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya pengguna terkait yang bisa melihat order
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('user.order.pending', compact('order'));
    }

    public function retry($id)
    {
        $order = Order::findOrFail($id);

        // Pastikan hanya pesanan pending yang dapat diulang pembayaran
        if ($order->status !== 'Pending') {
            return redirect()->route('user.orders')->with('error', 'Pesanan ini tidak dapat diulang pembayarannya.');
        }

        $snapToken = $this->getMidtransSnapToken($order);

        return view('user.order.retry', compact('snapToken', 'order'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // Validasi input
        $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Canceled,Delivery',
        ]);

        $order->status = $request->status;
        $order->save();
        // dd($order);

        toastr()->success('Order status updated successfully');
        return redirect()->route('admin.orders');
    }
    public function updateStatus(Request $request, Order $order)
    {
        // $this->authorize('update', $order); // Pastikan hanya pemilik pesanan yang bisa mengubah status

        $validated = $request->validate([
            'status' => 'required|in:Completed,Cancelled,Pending,Processing,Delivery',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return response()->json(['success' => true]);
    }
}
