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
                'mangach' => 'GV',
                'tenngach' => 'Giảng viên'
            ],
        );
    }
}
