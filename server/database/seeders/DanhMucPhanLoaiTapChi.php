<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DanhMucPhanLoaiTapChi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phanLoaiTapChis = [
            [
                'ma' => 'wos',
                'ten' => 'Wos'              
            ],
            [
                'ma' => 'abcd',
                'ten' => 'ABCD'              
            ],
            [
                'ma' => 'aci',
                'ten' => 'ACI'              
            ],
            [
                'ma' => 'quartile',
                'ten' => 'Scopus'              
            ],
            [
                'ma' => 'abs',
                'ten' => 'ABS'              
            ]
        ];

        foreach($phanLoaiTapChis as $item){
            DB::table('d_m_phan_loai_tap_chi')->insert($item);
        }
    }
}
