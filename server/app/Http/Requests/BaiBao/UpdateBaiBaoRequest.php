<?php

namespace App\Http\Requests\BaiBao;

use App\Rules\NameUniqueIfIdKeywordNull;
use App\Rules\NameUniqueIfIdTapchiNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateBaiBaoRequest extends FormRequest
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
                Rule::exists('san_phams', 'id')
            ],
            // Thong tin chi tiet bai bao
            "doi" => "bail|nullable|string",
            "url" => "bail|nullable|string",
            "received" => "bail|nullable|string",
            "accepted" => "bail|nullable|string",
            "published" => "bail|nullable|string",
            "abstract" => "bail|nullable|string",


            "keywords" => "bail|nullable|array",
            "keywords.*.id_keyword" => [
                "bail", "required", "integer",
                Rule::exists("keywords", "id")
            ],
            "keywords.*.name" => [
                "bail", "required", "string",
            ],



            "tapchi" => "bail|required",
            "tapchi.id_tapchi" => [
                "bail", "nullable", "integer",
                Rule::exists('tap_chis', 'id')
            ],
            "tapchi.name" => [
                "bail", "required", "string",
            ],
            "tapchi.issn" => "bail|nullable|string",
            "tapchi.eissn" => "bail|nullable|string",
            "tapchi.pissn" => "bail|nullable|string",
            "tapchi.website" => "bail|nullable|string",

            "volume" => "bail|nullable|string",
            "issue" => "bail|nullable|string",
            "number" => "bail|nullable|string",
            "pages" => "bail|nullable|string",

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
            'keyword.*.id_keyword.exists' => 'Keyword không tồn tại trên hệ thống',
            'tapchi.id_tapchi.exists' => 'Tạp chí không tồn tại trên hệ thống',
            'tapchi.name.unique' => 'Tên tạp chí đã tồn tại trên hệ thống',
        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
