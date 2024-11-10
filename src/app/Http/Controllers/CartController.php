<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity]
        );

        return back()->with('success', 'カートに追加しました');
    }

    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        if ($cart) {
            $cart->delete();
            return back()->with('success', '商品がカートから削除されました');
        }
        return back()->with('success', '商品が見つかりません');
    }

    public function view()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('Cart.cart', compact('carts'));
    }

    public function preparePayment(Request $request)
    {
        // カートから選択された商品を取得
        $selectedItems = Cart::whereIn('id', $request->selected_items)
            ->where('user_id', Auth::id())
            ->get();

        // 合計金額を計算
        $totalAmount = $selectedItems->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        // セッションに選択された商品と合計金額を保存
        session(['selected_items' => $selectedItems, 'total_amount' => $totalAmount]);

        // 決済ページに遷移
        return redirect()->route('payment-show');
    }
}
