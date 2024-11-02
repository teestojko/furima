<?php

namespace App\Http\Controllers\Products;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function show(Product $product)
    {
        return view('Products.show', compact('product'));
    }
}
