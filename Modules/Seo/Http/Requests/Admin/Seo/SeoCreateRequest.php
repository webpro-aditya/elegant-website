<?php

namespace Modules\Seo\Http\Requests\Admin\Seo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SeoCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('seo_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meta_title' => 'required|max:100|min:2',
        ];
            
        
    }

    public function messages()
    {
        return [
            'meta_title.required' => ':attribute is required',
            'meta_title.max' => ':attribute must be maximum of 100 character',
            'meta_title.min' => ':attribute must be minimum of 2 character',
        ];
    }

    public function attributes()
    {
        return [
            'meta_title' => 'Meta Title'
        ];
    }
}
