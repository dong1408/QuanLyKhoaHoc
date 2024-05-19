<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                [
                    'name' => 'Super Admin',
                    'description' => 'Quản lý toàn bộ hệ thống',
                    'mavaitro' => 'super_admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý tài khoản',
                    'description' => 'Quản lý user',
                    'mavaitro' => 'admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý bài báo',
                    'description' => 'Quản lý Bài Báo Khoa Học',
                    'mavaitro' => 'admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý đề tài',
                    'description' => 'Quản lý Đề Tài NCKH',
                    'mavaitro' => 'admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý phân quyền',
                    'description' => 'Quản lý phân quyền',
                    'mavaitro' => 'admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý tạp chí',
                    'description' => 'Quản lý tạp chí',
                    'mavaitro' => 'admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Quản lý tổ chức',
                    'description' => 'Quản lý tổ chức',
                    'mavaitro' => 'super_admin',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Giảng viên',
                    'description' => 'Giảng viên',
                    'mavaitro' => 'giangvien',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Sinh Viên',
                    'description' => 'Sinh viên',
                    'mavaitro' => 'sinhvien',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Guest',
                    'description' => 'guest',
                    'mavaitro' => 'guest',
                    'deleted_at' => null,
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
                ]
            ]
        ];

        foreach($roles as $role){
            DB::table('roles')->insert($role);
        }

    }
}
