<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
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
            "name" => "bail|required|string",
            "username" => "bail|required|string|unique:users,username",
            "email" => "bail|required|email|unique:users,email",
            // "password" => "bail|nullable|boolean",
            //            "role" => "bail|required|integer",
            // "changed" => "bail|required|integer",
            "ngaysinh" => "bail|nullable|string",
            "dienthoai" => "bail|nullable|string",
            "email2" => "bail|nullable|string",
            "orchid" => "bail|nullable|string",
            "id_tochuc" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "cohuu" => "bail|nullable|boolean",
            "keodai" => "bail|nullable|boolean",
            "dinhmucnghiavunckh" => "bail|nullable|string",
            "dangdihoc" => [
                "bail", "nullable", "string",
                Rule::in(["caohoc", "ncs"])
            ],
            "id_noihoc" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "id_ngachvienchuc" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_ngach_vien_chucs', 'id')
            ],
            "id_quoctich" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_quoc_gias', 'id')
            ],
            "id_hochamhocvi" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_hoc_ham_hoc_vis', 'id')
            ],
            "id_chuyenmon" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_chuyen_mons', 'id')
            ],
            "id_nganhtinhdiem" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_nganh_tinh_diems', 'id')
            ],
            "id_chuyennganhtinhdiem" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_chuyen_nganh_tinh_diems', 'id')
            ],
            "roles_id" => "bail", "array", "nullable",
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
            'boolean' => 'Trường :attribute phải là true/false',
            'id_tochuc.exists' => 'Tổ chức không tồn tại trên hệ thống',
            'id_noihoc.exists' => 'Nơi học không tồn tại trên hệ thống',
            'id_ngachvienchuc.exists' => 'Ngạch viên chức không tồn tại trên hệ thống',
            'id_quoctich.exists' => 'Quốc gia không tồn tại trên hệ thống',
            'id_hochamhocvi.exists' => 'Học hàm học vị không tồn tại trên hệ thống',
            'id_chuyenmon.exists' => 'Chuyên môn không tồn tại trên hệ thống',
            'id_nganhtinhdiem.exists' => 'Ngành tính điểm không tồn tại trên hệ thống',
            'id_chuyennganhtinhdiem.exists' => 'Chuyên ngành tính điểm không tồn tại trên hệ thống',
            'in' => 'Trường :attribute phải là một trong các giá trị null, :values',
            'username.unique' => 'Username đã tồn tại trong hệ thống',
            'email.unique' => 'Email đã tồn tại trong hệ thống',
            'roles_id.*.exists' => 'Vai trò không tồn tại trong hệ thống'
        ];
    }
}
