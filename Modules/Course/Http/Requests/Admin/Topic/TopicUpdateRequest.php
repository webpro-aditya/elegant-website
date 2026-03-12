<?php

namespace Modules\Course\Http\Requests\Admin\Topic;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class TopicUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('topic_update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required',
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
