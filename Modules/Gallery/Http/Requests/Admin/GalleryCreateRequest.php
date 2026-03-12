<?php

namespace Modules\Gallery\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('gallery_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_en' => 'required|max:50|min:2',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => ':attribute is required',
            'name_en.max' => ':attribute must be maximum of 50 character',
            'name_en.min' => ':attribute must be minimum of 2 character',
        ];
    }

    public function attributes()
    {
        return [
            'name_en' => 'Name',
        ];
    }
}
