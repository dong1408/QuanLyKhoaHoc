<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateRoleOfUserRequest extends FormRequest
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
                'required', 'integer',
                'exists:users,id',
            ],
            "roles_id" => "bail", "nullable", "array",
            "roles_id.*" => [
                "bail", "integer",
                Rule::exists('roles', 'id')
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
            'roles_id.*.exists' => 'Vai trò không tồn tại trong hệ thống'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
