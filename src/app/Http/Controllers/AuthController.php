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
        return view('index', compact('user_name','user','carts','categories','orders','order_status','products','reviews','tags'));
    }
}
