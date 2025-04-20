<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserEditRequest extends FormRequest
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'current_password' => 'required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
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
            'profile_image.image' => 'プロフィール画像は画像ファイルである必要があります。',
            'profile_image.mimes' => 'プロフィール画像の形式はjpeg、png、jpg、gifのいずれかである必要があります。',
            'profile_image.max' => 'プロフィール画像のサイズは2MB以内である必要があります。',
            'name.required' => '名前を入力してください。',
            'name.string' => '名前は文字列である必要があります。',
            'name.max' => '名前は255文字以内である必要があります。',
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.max' => 'メールアドレスは255文字以内である必要があります。',
            'current_password.required' => '現在のパスワードを入力してください。',
            'new_password.required' => '新しいパスワードを入力してください。',
            'new_password.min' => '新しいパスワードは8文字以上である必要があります。',
            'new_password.confirmed' => '新しいパスワードが確認用と一致しません。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->filled('new_password')) {
                if (! Hash::check($this->input('current_password'), $this->user()->password)) {
                    $validator->errors()->add('current_password', '現在のパスワードが正しくありません。');
                }
            }
        });
    }
}
