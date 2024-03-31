<?php

namespace App\Http\Requests\SanPham;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadFileMinhChungRequest extends FormRequest
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
            "file" => "bail|required|file|mimes:pdf,docx|max:20560",
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'file' => 'Trường :attribute phải là file',
            'mimes' => 'Chỉ nhận các loại file : :values',
            'max' => 'Dung lượng file phải < 20MB',
        ];
    }
}