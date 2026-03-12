<?php

namespace Modules\User\Http\Requests\Api\Role;

use App\Http\Requests\ApiRequest;

class RoleUpdateRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('role_update');
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
            'name' => 'required|unique:roles,name,' . $this->id,
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute is required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Name',
        ];
    }
}
