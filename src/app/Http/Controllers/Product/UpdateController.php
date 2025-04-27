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


class UpdateController extends Controller
{

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all();
        $conditions = Condition::all();
        return view('product.edit', compact('product', 'categories', 'conditions'));
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validatedData = $request->validated();

        $product->update([
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id'],
            'condition_id' => $validatedData['condition_id'],
        ]);

        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {
                Storage::delete('public/images/' . basename($image->path));
                $image->delete();
            }

            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('images', 'public');
                $publicPath = str_replace('public/', 'storage/', $path);
                Image::create([
                    'product_id' => $product->id,
                    'path' => $publicPath,
                ]);
            }
        }

    return redirect()->route('products-show', $product)->with('success', '商品情報が更新されました');
    }
}

