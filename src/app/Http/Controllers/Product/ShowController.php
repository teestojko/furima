<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }
}
