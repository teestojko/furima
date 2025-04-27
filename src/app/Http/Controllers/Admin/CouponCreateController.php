<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CouponCreateRequest;
use App\Models\Coupon;

class CouponCreateController extends Controller
{
    public function create()
    {
        return view('admin.coupon_create');
    }

    public function store(CouponCreateRequest $request)
{
    $validatedData = $request->validated();

    Coupon::create([
        'code' => $request->code,
        'discount' => $request->discount,
        'discount_type' => $request->discount_type,
        'valid_from' => $request->valid_from,
        'valid_until' => $request->valid_until,
    ]);

    return redirect()->route('admin.dashboard')->with('success', 'クーポンが作成されました');
}

}
