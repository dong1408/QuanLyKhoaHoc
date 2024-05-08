<?php

namespace App\Imports;

use App\Exceptions\Excel\FormatFileException;
use App\Exports\DataExport;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Illuminate\Support\Collection;
use Throwable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\ToCollection;

class ImportUser implements ToModel, WithHeadingRow, SkipsOnError
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public $successRecords = [];
    public $failedRecords = [];


    public function model(array $row)
    {

        $validator = Validator::make($row, [
            'name' => 'bail|required|string',
            'username' => 'bail|required|unique:users,username',
            'email' => 'bail|required|email|unique:users,email',
            'ngaysinh' => 'bail|nullable|date_format:Y-m-d',
        ], [
            'name.required' => 'không được bỏ trống trường name',
            'username.required' => 'không được bỏ trống trường username',
            'username.unique' => 'username đã tồn tại trên hệ thống',
            'email.required' => 'trường email là bắt buộc',
            'email.email' => 'email không đúng định dạng',
            'email.unique' => 'email đã tồn tại trên hệ thống',
            'ngaysinh.date_format' => 'Ngày sinh phải theo định dạng YYYY-MM-DD'
        ]);

        if ($validator->fails()) {
            $this->failedRecords[] = array_merge($row, ['kết quả' => $validator->errors()->first()]);
            return null;
        }

        $this->successRecords[] = array_merge($row, ['kết quả' => 'Thành công']);

        return new User([
            'name' => (string) $row['name'],
            'username' => (string) $row['username'],
            'email' => (string) $row['email'],
            'ngaysinh' => (string) $row['ngaysinh'],
            'password' => Hash::make((string) str_replace('-', '', $row['ngaysinh']))
        ]);
    }

    public function getSuccessRecords(): array
    {
        return $this->successRecords;
    }

    public function getFailedRecords(): array
    {
        return $this->failedRecords;
    }

    public function onError(Throwable $e)
    {
        // Xử lý lỗi nếu cần
    }
}
