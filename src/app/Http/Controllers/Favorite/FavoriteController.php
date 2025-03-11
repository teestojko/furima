<?php

namespace App\Http\Controllers\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function showFavorites()
    {
        $user = Auth::user();
        $favoriteProducts = $user->favoriteProducts;
        return view('my_page', compact('favoriteProducts'));
    }

    public function toggleFavorite(Product $product)
    {
        $user = Auth::user();

        if ($user->favoriteProducts->contains($product)) {
            $user->favoriteProducts()->detach($product);
            return response()->json(['status' => 'removed']);
        } else {
            $user->favoriteProducts()->attach($product);
            return response()->json(['status' => 'added']);
        }
    }

}


