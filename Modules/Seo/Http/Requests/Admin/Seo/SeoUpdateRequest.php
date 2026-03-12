<?php

namespace Modules\Seo\Http\Requests\Admin\Seo;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class SeoUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('seo_update');
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
            'meta_title' => 'required|max:100|min:2',
        ];
    }

    public function messages()
    {
        return [
            'meta_title.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'meta_title' => 'Meta Title',
        ];
    }
}
