<?php

namespace Modules\Course\Http\Requests\Admin\Syllabus;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class SyllabusUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('course_update');
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
            'description' => 'required',
            'heading' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'description.required' => ':attribute is required',
            'heading.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
            'description' => 'Description',
            'heading' => 'Heading',
        ];
    }
}
