<?php

namespace Modules\Course\Http\Requests\Admin\TrainingCalendar;

use Illuminate\Foundation\Http\FormRequest;

class TrainingCalendarCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('course_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'course_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'course_id' => 'Course id',
        ];
    }
}
