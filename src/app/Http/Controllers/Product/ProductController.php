<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Controller;



class ProductController extends Controller
{

    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('Product.create', compact('categories','conditions'));
    }

    public function store(ProductRequest $request)
    {
        $validatedData = $request->validated();

        $product = Product::create([
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id'],
            'condition_id' => $validatedData['condition_id'],
            'user_id' => auth()->id(),
            'condition_id' => $request->condition_id,
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
