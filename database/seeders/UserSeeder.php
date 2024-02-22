<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            //Thông tin đăng nhập
            'username' => '11074',
            'name' => 'Nguyễn Đăng Thuấn',
            'email' => 'thuannguyen@sgu.edu.vn',
            'role' => '9',
            'password' => Hash::make('Sgu@admin_2020'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            //Thông tin cá nhân
            'dienthoai' => '0982947046',
            'ngaysinh' => '15/06/1982',
            'email2' => 'thuanvatly@gmail.com',
            'orchid' => null,
            //Thuộc tổ chức, đơn vị nào
            'id_tochuc' => 1,
            'id_donvi' => 1,
            'id_ngachvienchuc' => 1,
            //Quốc tịch gì
            'id_quoctich' => 1,
            //Học hàm học vị ra sao
            'id_hochamhocvi' => 1,
        ]);
    }
}
