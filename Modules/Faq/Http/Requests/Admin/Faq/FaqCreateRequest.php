<?php

namespace Modules\Faq\Http\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class FaqCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('faq_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
 
}
