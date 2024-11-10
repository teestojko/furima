<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;


class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('Coupon.coupon', compact('coupons'));
    }


    public function apply(Request $request)
{
    $request->validate(['coupon_code' => 'required|string']);
    $coupon = Coupon::where('code', $request->coupon_code)
                    ->whereDate('start_date', '<=', now())
                    ->whereDate('end_date', '>=', now())
                    ->first();

    if (!$coupon) {
        return back()->withErrors(['coupon_code' => 'クーポンコードが無効です']);
    }

    // 商品や適用条件を確認し、適用後の金額を計算
    $discount = $this->calculateDiscount($coupon, $request->product_id);
    return back()->with('success', "クーポンが適用されました。割引額: {$discount}円");
}

}
