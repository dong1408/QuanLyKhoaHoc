<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'bail|required|string|unique:roles,name',
            'description' => 'bail|required|string',
            'permission_id' => 'bail|required|array',
            'permission_id.*' => [
                'integer',
                Rule::exists("permissions", 'id'),
            ]
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'array' => 'Trường :attribute phải là một mảng',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'permission_id.*.exists' => 'Quyền không tồn tại trên hệ thống',
            'name.unique' => 'Tên vai trò đã tồn tại trong hệ thống'
        ];
    }
}
