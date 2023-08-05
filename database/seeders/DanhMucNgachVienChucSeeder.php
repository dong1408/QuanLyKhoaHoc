<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucNgachVienChucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_ngach_vien_chucs')->insert(
            [
                'name' => 'GV',
                'fullname' => 'Giảng viên'
            ],
            [
                'name' => 'GVC',
                'fullname' => 'Giảng viên chính'
            ],
            [
                'name' => 'GVCC',
                'fullname' => 'Giảng viên cao cấp'
            ],
            [
                'name' => 'CV',
                'fullname' => 'Chuyên viên'
            ],
            [
                'name' => 'NCV',
                'fullname' => 'Nghiên cứu viên'
            ]
        );
    }
}
