<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function orderIndex()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items.product', 'status')  // OrderItemと関連するProduct、およびOrderのstatusを取得
            ->get();
        return view('order.history', compact('orders'));
    }
}
