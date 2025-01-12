<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $products = $user->products()->with('images')->get();

        // 平均評価を計算（出品商品のレビューの平均）
    $averageStars = $user->products()
        ->with('reviews')
        ->get()
        ->pluck('reviews')
        ->flatten()
        ->avg('stars'); // 'stars' はレビューの評価を保持するカラムの名前

        return view('profile.profile', [
            'user' => $user,
            'products' => $products,
            'averageStars' => $averageStars,
        ]);
    }

}
