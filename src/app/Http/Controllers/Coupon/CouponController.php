<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ApplyCouponRequest;
use App\Models\Coupon;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;


class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('coupon.coupon', compact('coupons'));
    }


    public function apply(ApplyCouponRequest $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('code', $request->coupon_code)
            ->where('is_active', true)
            ->whereDate('valid_from', '<=', now())
            ->whereDate('valid_until', '>=', now())
            ->first();
        if (!$coupon) {
            return back()->withErrors(['coupon_code' => 'クーポンが無効ですまたは有効期限が切れています']);
        }

        $selectedItems = session('selected_items', []);

        $purchaseAmount = Cart::where('user_id', Auth::id())
            ->whereIn('id', $selectedItems)
            ->get()
            ->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });



        if (empty($selectedItems) || $purchaseAmount === 0) {
            return back()->withErrors(['selected_items' => '選択された商品がありません。']);
        }


        if ($coupon->discount_type === 'fixed') {
            $discountedAmount = max(0, $purchaseAmount - $coupon->discount);
        } elseif ($coupon->discount_type === 'percentage') {
            $discountedAmount = $purchaseAmount * (1 - ($coupon->discount / 100));
        }

        // セッションに割引金額を保存
        session(['discounted_amount' => $discountedAmount]);

        return back();
    }

}
