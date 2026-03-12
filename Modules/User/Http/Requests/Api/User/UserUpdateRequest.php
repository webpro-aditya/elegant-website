<?php

namespace Modules\User\Http\Requests\Api\User;

use App\Http\Requests\ApiRequest;

class UserUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('user_update');
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
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $this->id,
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
            'email.required' => ':atribute is required',
            'email.unique' => ':attribute already exist',
            'password.required' => ':attribute is required',
            'password.min' => ':attribute must be minimum of 6 character',
            'password_confirm.required' => ':attribute is required',
            'role_id.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'password_confirm' => 'Confirm Password',
            'role_id' => 'Role',
        ];
    }
}
