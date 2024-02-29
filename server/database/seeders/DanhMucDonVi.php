<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucDonVi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_don_vis')->insert(
            [
                'id_tochuc' => 1,
                'madonvi' => 'QLKH',
                'tendonvi' => 'Phòng Quản lý Khoa học'
            ],
        );
    }
}
