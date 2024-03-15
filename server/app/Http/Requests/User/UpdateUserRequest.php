<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateUserRequest extends FormRequest
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
            "username" => [
                "bail", "required", "string",
                Rule::unique('users')->ignore(Route::input('id'), 'id')
            ],
            "name" => "bail|required|string",
            "email" => [
                "bail", "required", "string",
                Rule::unique('users')->ignore(Route::input('id'), 'id')
            ],
//            "role" => "bail|required|integer",
            "ngaysinh" => "bail|nullable|string",
            "dienthoai" => "bail|nullable|string",
            "email2" => "bail|nullable|string",
            "orchid" => "bail|nullable|string",
            "id_tochuc" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "id_donvi" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_don_vis', 'id')
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
            'id_donvi.exists' => 'Đơn vị không tồn tại trên hệ thống',
            'id_tochuc.exists' => 'Tổ chúc không tồn tại trên hệ thống',
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
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
