<?php

namespace Modules\Course\Http\Requests\Admin\TrainingCalendar;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class TrainingCalendarUpdateRequest extends FormRequest
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
            'course_id' => 'Cours id',
        ];
    }
}
