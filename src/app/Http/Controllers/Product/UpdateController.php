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
        return view('Product.edit', compact('product', 'categories', 'conditions'));
    }

    public function update(ProductRequest $request, Product $product)
    {
    // 認証済みユーザーが出品者かどうかをチェック
        $this->authorize('update', $product);

        // バリデーション
        $validatedData = $request->validated();

        // 商品情報の更新
        $product->update([
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'price' => $validatedData['price'],
            'stock' => $validatedData['stock'],
            'category_id' => $validatedData['category_id'],
            'condition_id' => $validatedData['condition_id'],
        ]);

        // 画像の更新処理
        if ($request->hasFile('images')) {
            // 既存の画像を削除
            foreach ($product->images as $image) {
                Storage::delete('public/images/' . basename($image->path));
                $image->delete();
            }

            // 新しい画像を保存
            foreach ($request->file('images') as $imageFile) {
                $path = $imageFile->store('public/images');
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
