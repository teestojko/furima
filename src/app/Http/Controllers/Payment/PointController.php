<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function apply(Request $request)
    {
        $user = Auth::user();
        $usePoints = intval($request->use_points);
        $maxPoints = min($user->points, session('discounted_amount', session('total_amount')));

        if ($usePoints > $maxPoints) {
            return back()->withErrors(['use_points' => '使用できるポイントを超えています。']);
        }

        // 使ったポイントをセッションに保存
        session(['used_points' => $usePoints]);

        // `final_amount` を更新
        $discountedAmount = session('discounted_amount', session('total_amount'));
        $finalAmount = max(0, $discountedAmount - $usePoints);
        session(['final_amount' => $finalAmount]);

        return back()->with('success', "$usePoints ポイントを使用しました。");
    }
}
