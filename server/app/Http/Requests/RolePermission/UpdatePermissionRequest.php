<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdatePermissionRequest extends FormRequest
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
                Rule::exists('permissions', 'id')
            ],
            'name' => 'bail|required|string',
            'slug' => [
                "bail", "required", "string",
                Rule::unique('permissiosn')->ignore(Route::input('id'), 'id')
            ],
            'description' => 'bail|nullable|string|'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'slug.unique' => 'Slug phải là duy nhất trong hệ thống'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
