<?php

namespace Modules\Cms\Http\Requests\Admin\Contents;

// use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class ContentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('contents_update');
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
        ];
    }

    public function messages()
    {
        return [ 
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'Title',
        ];
    }
}
