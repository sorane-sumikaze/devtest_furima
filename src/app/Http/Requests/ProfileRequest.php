<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_name'     => ['required', 'string', 'max:20'],
            'post_code'     => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['required', 'string'],
            'building'      => ['nullable', 'string'],
            'profile_image' => ['nullable', 'mimes:jpeg,png'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required'  => 'お名前を入力してください',
            'user_name.max'       => 'お名前は20文字以内で入力してください',
            'post_code.required'  => '郵便番号を入力してください',
            'post_code.regex'     => '郵便番号はハイフンありの8文字で入力してください',
            'address.required'    => '住所を入力してください',
            'profile_image.mimes' => 'プロフィール画像は.jpegまたは.png形式で選択してください',
        ];
    }
}
