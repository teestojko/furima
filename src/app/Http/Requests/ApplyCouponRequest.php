<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplyCouponRequest extends FormRequest
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
            'coupon_code' => 'nullable|string|exists:coupons,code|required_without:coupon_id',
            'coupon_id' => 'nullable|integer|exists:coupons,id|required_without:coupon_code',
        ];
    }

    public function messages()
    {
        return [
            'coupon_code.required_without' => 'クーポンコードまたはクーポン選択のどちらかを指定してください。',
            'coupon_code.exists' => '指定されたクーポンは無効です。',
            'coupon_id.required_without' => 'クーポンコードまたはクーポン選択のどちらかを指定してください。',
            'coupon_id.exists' => '指定されたクーポンは存在しません。',
        ];
    }
}
