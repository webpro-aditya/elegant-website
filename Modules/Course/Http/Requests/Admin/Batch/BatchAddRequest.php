<?php

namespace Modules\Course\Http\Requests\Admin\Batch;

use Illuminate\Foundation\Http\FormRequest;

class BatchAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
