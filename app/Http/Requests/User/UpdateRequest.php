<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|string|min:6|max:255',
            'phone' => 'required|regex:/0[1-9]{3}[0-9]{6}/|unique:users,phone,' . request()->id,
            'avatar' => 'mimes:png,jpg,jpeg|max:5048',
        ];
    }
}
