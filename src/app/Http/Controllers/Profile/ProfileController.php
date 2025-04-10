<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        $products = $user->products()->with('images')->get();

        $averageStars = $user->products()
            ->with('reviews')
            ->get()
            ->pluck('reviews')
            ->flatten()
            ->avg('stars');

        return view('profile.profile', compact('user', 'products', 'averageStars'));
    }
}
