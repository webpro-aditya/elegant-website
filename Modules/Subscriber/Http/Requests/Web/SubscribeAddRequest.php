<?php

namespace Modules\Subscriber\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    // public function authorize()
    // {
    //     return auth()->user()->can('gallery_create');
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'Email',
        ];
    }
}
