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
            'name' => 'Nguyễn Đăng Thuấn',
            'email' => 'thuannguyen@sgu.edu.vn',
            'email2' => 'thuanvatly@gmail.com',
            'mavienchuc' => '11074',
            'dienthoai' => '0982947046',
            'ngaysinh' => '15/06/1982',
            'id_noicongtac' => 1,
            'id_donvi' => 1,
            'id_quoctich' => 1,
            'id_hochamhocvi' => 1,
            'id_ngachvienchuc' => 1,
            'orchid' => null,
            'role' => '9',
            'password' => Hash::make('Sgu@admin_2020'),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
