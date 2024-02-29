<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucToChuc extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_to_chucs')->insert(
            [
                'matochuc' => 'SGU',
                'tentochuc' => 'Trường Đại học Sài Gòn',
                'tentochuc_en' => 'Saigon University',
                'website' => 'https://sgu.edu.vn',
                'dienthoai' => '',
                'address' => '273 An Dương Vương, P3, Q5, TPHCM',
                'id_address_city' => 1,
                'id_address_country' => 1,
                'id_phanloaitochuc' => 1,
            ]
        );
    }
}
