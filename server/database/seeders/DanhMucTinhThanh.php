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
        $tinhThanhs = [
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'HCM',
                'tentinhthanh' => 'Thành phố Hồ Chí Minh'
            ],
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'HN',
                'tentinhthanh' => 'Hà Nội'
            ],
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'ND',
                'tentinhthanh' => 'Nam Định'
            ]
        ];

        foreach($tinhThanhs as $item){
            DB::table('d_m_tinh_thanhs')->insert($item);
        }
    }
}
