<?php

namespace App\Http\Requests\Voucher;

use App\Models\Voucher;
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
            'quantity' => 'required|numeric|min:1',
            'value' => 'required|numeric|min:1',
            'condition_min_price' => 'required|numeric|min:0',
            'maximum_reduction' => 'required|numeric|min:1',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('validation.required', ['name' => __('titles.name')]),
            'name.string' => __('validation.required', ['name' => __('titles.name')]),
            'name.min' => __('validation.min', ['name' => __('titles.name'), 'min' => '6']),
            'name.max' => __('validation.max', ['name' => __('titles.name'), 'max' => '255']),
            'quantity.required' => __('validation.required', ['name' => __('titles.quantity')]),
            'quantity.numeric' => __('validation.numeric', ['name' => __('titles.quantity')]),
            'quantity.min' => __('validation.min', ['name' => __('titles.quantity'), 'min' => '1']),
            'value.required' => __('validation.required', ['name' => __('titles.value')]),
            'value.numeric' => __('validation.numeric', ['name' => __('titles.value')]),
            'value.min' => __('validation.min', ['name' => __('titles.value'), 'min' => '1']),
            'condition_min_price.required' => __('validation.required', ['name' => __('titles.condition_min_price')]),
            'condition_min_price.numeric' => __('validation.numeric', ['name' => __('titles.condition_min_price')]),
            'condition_min_price.min' => __('validation.min', [
                'name' => __('titles.condition_min_price'),
                'min' => '0',
            ]),
            'maximum_reduction.required' => __('validation.required', ['name' => __('titles.maximum_reduction')]),
            'maximum_reduction.numeric' => __('validation.numeric', ['name' => __('titles.maximum_reduction')]),
            'maximum_reduction.min' => __('validation.min', ['name' => __('titles.maximum_reduction'), 'min' => '1']),
            'start_date.required' => __('validation.required', ['name' => __('titles.start_date')]),
            'end_date.required' => __('validation.required', ['name' => __('titles.end_date')]),
        ];
    }
}
