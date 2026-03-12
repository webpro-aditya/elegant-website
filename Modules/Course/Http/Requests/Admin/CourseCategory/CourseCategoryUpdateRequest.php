<?php

namespace Modules\Course\Http\Requests\Admin\CourseCategory;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class CourseCategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('course_category_update');
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
            'parent_category_id' => 'nullable|integer|different:id',
        ];
    }

    public function messages()
    {
        return [
            'parent_category_id.different' => 'The category and parent category cannot be the same.',

        ];
    }

    public function attributes()
    {
        return [
            'id' => 'Category ID',
            'parent_category_id' => 'Parent Category ID',
        ];
    }
}
