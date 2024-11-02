<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'detail' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ];
    }

    /**
     * Custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'name.string' => '商品名は文字列である必要があります。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'detail.required' => '商品の詳細は必須です。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値である必要があります。',
            'stock.required' => '在庫数は必須です。',
            'stock.integer' => '在庫数は整数である必要があります。',
            'category_id.required' => 'カテゴリーは必須です。',
            'category_id.exists' => '選択したカテゴリーは存在しません。',
            'condition_id.required' => '商品の状態は必須です。',
            'condition_id.exists' => '選択した商品の状態は存在しません。',
            'images.*.image' => '画像ファイルのみアップロードできます。',
            'images.*.mimes' => '画像はjpeg、png、jpg、gifの形式でアップロードしてください。',
            'images.*.max' => '画像ファイルのサイズは4MB以下にしてください。',
        ];
    }
}
