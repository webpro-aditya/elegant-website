<?php

namespace Modules\Course\Http\Requests\Admin\Discount;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCreateRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('discount_create');
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'code' => 'required',
            'valid_from' => 'required',
            'valid_to' => 'required',
            'attempt_per_user' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'code.required' => ':attribute is required',
            'valid_from.required' => ':attribute is required',
            'valid_to.required' => ':attribute is required',
            'attempt_per_user.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'code' => 'Code',
            'valid_from' => 'Valid From Date',
            'valid_to' => 'Valid To Date',
            'attempt_per_user' => 'Attempts Per user',
        ];
    }
}
