<?php

namespace App\Http\Controllers\Product;

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
        $categories = Category::all();
        $query = Product::query();

        // カテゴリでの絞り込み
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 商品名での部分一致検索
        if ($request->filled('product_name')) {
            $query->where('name', 'like', '%' . $request->product_name . '%');
        }

        // 価格帯での検索
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        // 価格順での並び替え
        if ($request->filled('price_order') && in_array($request->price_order, ['asc', 'desc'])) {
            $query->orderBy('price', $request->price_order);
        }

        // 人気順での並び替え (仮に「注文回数が多い順」で人気を定義する場合)
        if ($request->filled('popularity') && $request->popularity == 'desc') {
            $query->withCount('orders')->orderBy('orders_count', 'desc');
        }

        $products = $query->get();

        return view('index', compact('user_name', 'user', 'products', 'categories'));
    }
}
