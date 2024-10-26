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

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function userMyPage()
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
        $products = Product::all();
        $reviews = Review::all();
        $tags = Tag::all();
        dd($categories);
        return view('index', compact('user_name','user','carts','categories','orders','order_status','products','reviews','tags'));
    }
}
