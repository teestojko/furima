<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponCreateRequest extends FormRequest
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
            'code' => 'required|unique:coupons,code|max:255',
            'discount' => 'required|numeric|min:1',
            'discount_type' => 'required|in:fixed,percentage',
            'valid_from' => 'required|date|before:valid_until',
            'valid_until' => 'required|date|after:today',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'クーポンコードは必須です。',
            'code.unique' => 'このクーポンコードは既に使用されています。',
            'code.max' => 'クーポンコードは255文字以内で入力してください。',
            'discount.required' => '割引額を入力してください。',
            'discount.numeric' => '割引額は数値で入力してください。',
            'discount.min' => '割引額は1以上で入力してください。',
            'discount_type.required' => '割引タイプを選択してください。',
            'discount_type.in' => '割引タイプは「fixed」または「percentage」である必要があります。',
            'valid_from.required' => '有効開始日を入力してください。',
            'valid_from.date' => '有効開始日は正しい日付形式で入力してください。',
            'valid_from.before' => '有効開始日は有効終了日より前である必要があります。',
            'valid_until.required' => '有効終了日を入力してください。',
            'valid_until.date' => '有効終了日は正しい日付形式で入力してください。',
            'valid_until.after' => '有効終了日は今日以降の日付である必要があります。',
        ];
    }
}
