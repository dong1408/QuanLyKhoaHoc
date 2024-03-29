<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Hash;


class ImportUser implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row[0],
            'username' => $row[1],
            'email' => $row[2],
            'ngaysinh' => $row[3],
            'password' => Hash::make(env('SGU_2024'))
        ]);
    }
}
