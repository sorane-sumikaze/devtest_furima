<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image'        => ['required', 'mimes:jpeg,png'],
            'item_name'    => ['required', 'string', 'max:255'],
            'brand_name'   => ['nullable', 'string', 'max:255'],
            'price'        => ['required', 'integer', 'min:0'],
            'description'  => ['required', 'string', 'max:255'],
            'condition'    => ['required', 'integer', 'between:1,4'],
            'categories'   => ['required', 'array'],
            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required'       => '商品画像を選択してください',
            'image.mimes'          => '商品画像は.jpegまたは.png形式で選択してください',
            'item_name.required'   => '商品名を入力してください',
            'price.required'       => '販売価格を入力してください',
            'price.integer'        => '販売価格は整数で入力してください',
            'description.required' => '商品説明を入力してください',
            'condition.required'   => '商品の状態を選択してください',
            'categories.required'  => '商品のカテゴリーを選択してください',
        ];
    }
}
