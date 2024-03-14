<?php

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddPermissionRequest extends FormRequest
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
            'name' => 'bail|required|string',
            'slug' => 'bail|required|string|unique:permissions,slug',
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
}
