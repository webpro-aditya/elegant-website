<?php

namespace Modules\User\Http\Requests\Api\User;

use App\Http\Requests\ApiRequest;

class UserPasswordUpdateRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('user_update');
    }

    public function rules()
    {
        return [
            'password' => 'required',
            'confirm_password' => 'required_with:password|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => ':attribute is required',
            'confirm_password.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'password' => 'Password',
            'confirm_password' => 'Confirm password',
        ];
    }
}
