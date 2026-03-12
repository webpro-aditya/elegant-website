<?php

namespace Modules\Career\Http\Requests\Admin\Career;

use Illuminate\Foundation\Http\FormRequest;

class CareerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('career_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|max:50|min:2',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'title.max' => ':attribute must be maximum of 50 character',
            'title.min' => ':attribute must be minimum of 2 character',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',

        ];
    }
}
