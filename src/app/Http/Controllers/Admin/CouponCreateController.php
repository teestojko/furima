<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponCreateController extends Controller
{
    public function create()
    {
        return view('Admin.coupon_create'); // クーポン作成画面へのビュー
    }

    public function store(Request $request)
{
    $request->validate([
        'code' => 'required|unique:coupons,code|max:255',
        'discount' => 'required|numeric|min:1',
        'discount_type' => 'required|in:fixed,percentage', // 新しいバリデーション
        'valid_from' => 'required|date|before:valid_until',
        'valid_until' => 'required|date|after:today', // フィールド名を一致させる
    ]);

    Coupon::create([
        'code' => $request->code,
        'discount' => $request->discount,
        'discount_type' => $request->discount_type,
        'valid_from' => $request->valid_from,
        'valid_until' => $request->valid_until,
    ]);

    return redirect()->route('admin-dashboard')->with('success', 'クーポンが作成されました');
}

}
