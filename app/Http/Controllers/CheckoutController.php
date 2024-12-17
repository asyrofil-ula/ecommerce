<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use Midtrans\Config;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Ambil ID pengguna yang sedang login

        // Ambil item keranjang berdasarkan user_id
        $cartItems = Cart::where('user_id', $userId)
            ->with('product') // Pastikan ada relasi 'product'
            ->get();

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price * $cartItem->quantity;
        });

        return view('user.checkout', compact('cartItems', 'totalPrice'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'email' => 'required|email',
            'payment_method' => 'required|in:midtrans,cod',
        ]);

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang Anda kosong!');
        }

        // Hitung total harga
        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Simpan data pesanan
        $order = Order::create([
            'user_id' => $userId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'notes' => $request->order_notes,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            'status' => $request->payment_method === 'cod' ? 'pending' : 'processing',
        ]);

        // Simpan item pesanan
        foreach ($cartItems as $cartItem) {
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->price,
                'total' => $cartItem->product->price * $cartItem->quantity,
            ]);
        }

        // Kosongkan keranjang
        Cart::where('user_id', $userId)->delete();

        // Metode pembayaran
        if ($request->payment_method === 'cod') {
            // Jika COD
            return redirect()->route('user.dashboard')->with('success', 'Pesanan Anda berhasil dibuat. Silakan tunggu konfirmasi.');
        } else {
            // Jika menggunakan Midtrans
            return $this->processMidtrans($order, $cartItems);
        }
    }

    private function processMidtrans($order, $cartItems)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $transactionDetails = [
            'order_id' => $order->id,
            'gross_amount' => $order->total_price,
        ];

        $itemDetails = $cartItems->map(function ($item) {
            return [
                'id' => $item->product_id,
                'price' => $item->product->price,
                'quantity' => $item->quantity,
                'name' => $item->product->name,
            ];
        })->toArray();

        $customerDetails = [
            'first_name' => $order->first_name,
            'last_name' => $order->last_name,
            'email' => $order->email,
            'phone' => $order->mobile,
            'address' => $order->address,
        ];

        $transaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($transaction);
            return view('user.midtrans', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam memproses pembayaran.');
        }
    }
    public function retry($id)
    {
        $order = Order::findOrFail($id);
    
        // Pastikan hanya pesanan dengan status 'pending' yang dapat diulang pembayarannya
        if ($order->status !== 'pending') {
            return redirect()->route('user.orders')->with('error', 'Pesanan ini tidak dapat diulang pembayarannya.');
        }
    
        // Mendapatkan token Snap dari Midtrans
        try {
            $cartItems = Cart::where('user_id', $order->user_id)->get(); // Pastikan relasi 'items' sudah didefinisikan di model Order
            $snapToken = $this->processMidtrans($order, $cartItems);
        } catch (\Exception $e) {
            return redirect()->route('user.orders')->with('error', 'Terjadi kesalahan saat memproses pembayaran: ' . $e->getMessage());
        }
    
        if ($snapToken === null) {
            return redirect()->route('user.orders')->with('error', 'Sesi pembayaran telah habis. Silakan ulangi pembayaran.');
        }
    
        // Mengarahkan ke halaman retry pembayaran
        return view('user.order.retry', compact('snapToken', 'order'));
    }
    
}