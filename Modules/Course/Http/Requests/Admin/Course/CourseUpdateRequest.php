<?php

namespace Modules\Course\Http\Requests\Admin\Course;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class CourseUpdateRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'id' => 'required',
            'title' => 'required',
            'category_id' => 'required',
            // 'start_date' => 'required',
            'demo_video_url' => 'nullable|string|max:191',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute is required',
            'category_id.required' => ':attribute is required',
            'start_date.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'title',
            'category_id' => 'category',
            'start_date' => 'date',
            'demo_video_url' => 'Demo Video Url',
        ];
    }
}
