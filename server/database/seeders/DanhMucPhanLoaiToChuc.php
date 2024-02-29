<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucPhanLoaiToChuc extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_phan_loai_to_chucs')->insert(
            [
                'maloai' => 'TrDH',
                'tenloai' => 'Trường đại học',
                'tenloai_en' => ''
            ],
        );
    }
}
