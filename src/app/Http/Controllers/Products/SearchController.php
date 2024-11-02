<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function filter(Request $request)
    {
        $user_name = auth()->check() ? auth()->user()->name : null;
        $user = Auth::user();
        $categories = category::all();
        $query = product::query();
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('product_name')) {
        $query->where('name', 'like', $request->product_name . '%');
        }
        $products = $query->get();
        return view('index', compact('user_name', 'user', 'products', 'categories'));
    }
}
