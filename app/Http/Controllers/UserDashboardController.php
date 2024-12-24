<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\BestProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{

    public function index()
    {
        $allProducts = Product::with('category')->limit(16)->get();
        $bestproducts = BestProducts::with('product')->limit(5)->get();
        // dd($bestproducts);
        $cart = Cart::where('user_id', Auth::id())->get();
        $categories = Category::with('products')->get();
        return view('user.dashboard', compact('allProducts', 'categories', 'bestproducts', 'cart'));
    }
}
