<?php

namespace Modules\Course\Http\Requests\Admin\Topic;

use Illuminate\Foundation\Http\FormRequest;

class TopicCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('topic_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'category_id.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'category_id' => 'Category',
        ];
    }
}
