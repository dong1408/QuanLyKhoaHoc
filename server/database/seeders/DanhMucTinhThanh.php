<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
                'tentinhthanh' => 'Thành phố Hồ Chí Minh',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'HN',
                'tentinhthanh' => 'Hà Nội',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'id_quocgia' => 1,
                'matinhthanh' => 'ND',
                'tentinhthanh' => 'Nam Định',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        foreach($tinhThanhs as $item){
            DB::table('d_m_tinh_thanhs')->insert($item);
        }
    }
}
