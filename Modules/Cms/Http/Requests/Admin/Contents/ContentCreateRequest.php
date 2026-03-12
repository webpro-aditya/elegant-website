<?php

namespace Modules\Cms\Http\Requests\Admin\Contents;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('contents_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $section = config('settings.config.section'); 
        return [
           
            'title' => [
                'required',
                'max:100',
                'min:2'
            ],
        ];
    }

    public function messages()
    {
        return [
           
            'title.required' => ':attribute is required',
            'title.max' => ':attribute must be maximum of 100 character',
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
