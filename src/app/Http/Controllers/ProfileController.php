<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Product;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $products = $user->products()->with('images')->get();
        return view('Profile.profile', [
            'user' => $user,
            'products' => $products,
        ]);
    }

}
