<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Review;
use App\Models\Tag;
use App\Models\Coupon;

class AuthController extends Controller
{
    public function index()
    {
        $user_name = null;
        $user = null;
        $carts = Cart::all();
        $categories = Category::all();
        $orders = Order::all();
        $order_status = OrderStatus::all();
        $products = Product::with('user', 'images')->get();
        $reviews = Review::all();
        $tags = Tag::all();
        $points = null;
        $coupons = Coupon::where('is_active', true)
            ->where('is_used', false) // 未使用のクーポン
            ->get();

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

    public function userIndex()
    {
        $user_name = null;
        if (auth()->check()) {
            $user_name = auth()->user()->name;
        }
        $user = Auth::user();
        $carts = Cart::all();
        $categories = Category::all();
        $orders = Order::all();
        $order_status = OrderStatus::all();
        $products = Product::with('user', 'images')->get();
        $reviews = Review::all();
        $tags = Tag::all();
        $points = $user ? $user->points : 0;
        $coupons = Coupon::where('is_active', true)
            ->where('is_used', false) // 未使用のクーポン
            ->get();

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
            'coupons'));
    }
}
