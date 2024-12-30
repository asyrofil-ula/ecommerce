<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
                         ->with('product')
                         ->get();

        return view('user.cart', compact('cartItems'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function addToCart(Request $request)
     {
         $request->validate([
             'product_id' => 'required|exists:products,id',
         ]);
 
         $userId = Auth::id(); // Ambil ID pengguna yang sedang login
 
         // Cari apakah produk sudah ada di keranjang pengguna
         $cartItem = Cart::where('user_id', $userId)
                         ->where('product_id', $request->product_id)
                         ->first();
 
         if ($cartItem) {
             // Jika sudah ada, tambahkan quantity
             $cartItem->quantity += 1;
             $cartItem->save();
         } else {
             // Jika belum ada, tambahkan produk ke keranjang
             Cart::create([
                 'user_id' => $userId,
                 'product_id' => $request->product_id,
                 'quantity' => 1,
             ]);
         }
 
         return redirect()->back()->with('success', 'Product added to cart successfully!');
     }
 
     public function updateCart(Request $request)
     {
         $request->validate([
             'cart_id' => 'required|exists:carts,id',
             'quantity' => 'required|integer|min:1',
         ]);
     
         $cartItem = Cart::find($request->cart_id);
     
         if ($cartItem) {
             $cartItem->quantity = $request->quantity;
             $cartItem->save();
     
             return response()->json([
                 'success' => true,
                 'message' => 'Cart updated successfully!',
             ]);
         }
     
         return response()->json([
             'success' => false,
             'message' => 'Cart item not found!',
         ]);
     }
     
     
     

     public function removeFromCart($id)
     {
         $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->first();
     
         if ($cartItem) {
             $cartItem->delete();
             toastr()->success('Product removed from cart successfully!');
             return redirect()->back();
         }
         toastr()->error('Product not found in cart!');
         return redirect()->back();
     }
     

    public function checkout()
    {
        $cartItems = session()->get('cart', []);

        if(empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }
         // Di sini Anda bisa menambahkan logika untuk membuat pesanan
        // Misalnya, memindahkan item keranjang ke tabel pesanan

        // Kosongkan keranjang setelah checkout
        session()->forget('cart');
        
        return redirect()->route('orders.index')->with('success', 'Order has been placed successfully!');
    }
}
