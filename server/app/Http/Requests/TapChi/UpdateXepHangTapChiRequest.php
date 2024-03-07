<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateXepHangTapChiRequest extends FormRequest
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
            "wos" => [
                "bail","nullable","string",
                Rule::in(["SCIE","SSCI","A&HCI","ESCI"])
            ],
            "if" => "bail|nullable|string",
            "quartile" => [
                "bail","nullable","string",
                Rule::in(["q1","q2","q3","q4"])
            ],
            "abs" => [
                "bail","nullable","string",
                Rule::in(["1","2","3","4"])
            ],
            "abcd" => [
                "bail","nullable","string",
                Rule::in(["A*","A","B","C"])
            ],
            "aci" => [
                "bail","nullable","string",
                Rule::in(["0","1"])
            ],
            "ghichu" => "bail|nullable|string",
        ];
    }

    public function  messages(){
        return [
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'in' => 'Trường :attribute phải là một trong các giá trị :values'
        ];
    }
}
