<?php

namespace Modules\Course\Http\Requests\Admin\Discount;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class DiscountUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('discount_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'id' => 'required',
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
