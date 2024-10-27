<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Http\Requests\ProductCreateRequest;



class ProductController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('products_create', compact('categories'));
    }

    public function store(ProductCreateRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create([
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id'],
            'user_id' => auth()->id(),
        ]);

        $imagesUploaded = $request->hasFile('images');
            if ($imagesUploaded) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('public/images');
                    $publicPath = str_replace('public/', 'storage/', $path);
                    Image::create([
                        'product_id' => $product->id,
                        'path' => $publicPath,
                    ]);
                }
            }
            return back()->with('success', $imagesUploaded ? '商品が出品されました' : '画像が選択されていません');

    }
}
