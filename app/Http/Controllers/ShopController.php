<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\BestProducts;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $categoryId = $request->input('category');

        // Query Produk
        $query = Product::query();
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->paginate(9);

        // Data lain
        $categories = Category::withCount('products')->get();
        $bestproducts = BestProducts::all();

        // dd($bestproducts);

        return view('user.shop', compact('products', 'categories', 'bestproducts'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        $bestProducts = BestProducts::with('product')->limit(5)->get();
        // dd($bestProducts);
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->limit(5)->get();
        return view('user.product-detail', compact('product', 'bestProducts', 'relatedProducts'));
    }
}
