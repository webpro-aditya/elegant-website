<?php

namespace Modules\Enquiry\Http\Requests\Admin\Brochure;

use Illuminate\Foundation\Http\FormRequest;

class BrochureDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('brochure_delete');
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
        ];
    }
}
