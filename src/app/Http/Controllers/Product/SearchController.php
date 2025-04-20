<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Coupon;

class SearchController extends Controller
{
    public function filter(Request $request)
    {
        $user_name = auth()->check() ? auth()->user()->name : null;
        $user = Auth::user();
        $categories = Category::all();
        $carts = Cart::all();
        $orders = Order::all();
        $order_status = OrderStatus::all();
        $reviews = Review::all();
        $tags = Tag::all();
        $points = $user ? $user->points : 0;
        $coupons = Coupon::where('is_active', true)
            ->where('is_used', false)
            ->get();

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

        return view('index', compact(
        'user_name',
        'user',
        'carts',
        'categories',
        'orders',
        'order_status',
        'products',
        'reviews',
        'tags',
        'points',
        'coupons'
    ));
    }
}

