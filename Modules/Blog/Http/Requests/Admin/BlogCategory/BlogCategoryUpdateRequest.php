<?php

namespace Modules\Blog\Http\Requests\Admin\BlogCategory;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class BlogCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('blog_category_update');
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
            'name_en' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_en.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'name_en' => 'Name',
        ];
    }
}
