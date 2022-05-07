<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|min:3|max:28|unique:products',
            'quantity' => 'required|integer|digits_between:1,5',
            'price' => 'required|numeric|digits_between:4,9',
            'description' => 'required|min:3|max:10000',
            'image_thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:1109',
            'images' => 'required|min:2|max:4',
            'images.*'  => 'image|mimes:jpg,png,jpeg',
        ];
    }
}
