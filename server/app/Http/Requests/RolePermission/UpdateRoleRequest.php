<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateRoleRequest extends FormRequest
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
            'id' => [
                "bail", "required", "integer",
                Rule::exists('roles', 'id')
            ],
            'name' => [
                "bail", "required", "string",
                Rule::unique('roles')->ignore(Route::input('id'), 'id')
            ],
            'description' => 'bail|required|string',
            'permission_id' => 'bail|required|array',
            'mavaitro' => [
                'bail','required','string',
                Rule::in(['admin','super_admin','giangvien','sinhvien','guest'])
            ],
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
            'in' => 'Trường :attribute chỉ nhận các giá trị :values'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
