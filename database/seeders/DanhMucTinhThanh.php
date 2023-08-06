<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucTinhThanh extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('d_m_tinh_thanhs')->insert(
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'HCM',
                'tentinhthanh' => 'Thành phố Hồ Chí Minh'
            ],
        );
    }
}
