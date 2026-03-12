<?php

namespace Modules\Blog\Http\Requests\Admin\Blog;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('blog_create');
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
            'category_id' => 'required',
            'author_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'title.max' => ':attribute must be maximum of 50 character',
            'title.min' => ':attribute must be minimum of 2 character',

            'category_id.required' => ':attribute is required',

            'author_id.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'category_id' => 'Category',
            'author_id' => 'Author',
        ];
    }
}
