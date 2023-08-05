<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucPhanLoaiNoiCongTac extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_phan_loai_noi_cong_tacs')->insert(
            [
                'name' => 'Trường đại học',
            ],
            [
                'name' => 'Đại học',
            ],
            [
                'name' => 'Viện nghiên cứu',
            ],
        );
    }
}
