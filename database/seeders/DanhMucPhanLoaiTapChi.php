<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucPhanLoaiTapChi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_phan_loai_tap_chis')->insert(
            [
                'name' => 'SCI',
                'fullname' => 'Tạp chí SCI (thuộc WoS)'
            ],
        );
    }
}
