<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class SaleController extends Controller
{
    public function showSalesHistory()
    {
        $sales = Order::whereHas('items.product', function ($query) {
            $query->where('user_id', Auth::id());
        })->with(['items.product'])->get();
        return view('sale.history', compact('sales'));
    }

}
