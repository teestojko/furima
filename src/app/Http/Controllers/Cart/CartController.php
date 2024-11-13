<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        // クーポンがリクエストまたはセッションに存在するかを確認
        $coupon = session('applied_coupon'); // クーポン情報がセッションにある場合を想定
        if ($coupon) {
            if ($coupon->discount_type === 'fixed') {
                $discountedAmount = max(0, $totalAmount - $coupon->discount);
            } elseif ($coupon->discount_type === 'percentage') {
                $discountedAmount = $totalAmount * (1 - ($coupon->discount / 100));
            }
            session(['discounted_amount' => $discountedAmount]);
        } else {
            // クーポンがない場合、割引なしの合計金額を保存
            session(['discounted_amount' => $totalAmount]);
        }

        // // セッションに選択された商品と合計金額を保存
        // session(['selected_items' => $selectedItems, 'total_amount' => $totalAmount]);

        // 配列形式で保存
        session(['selected_items' => $selectedItems->pluck('id')->toArray(), 'total_amount' => $totalAmount]);
        // dd($selectedItems);


        // 決済ページに遷移
        return redirect()->route('payment-show');
    }

}
