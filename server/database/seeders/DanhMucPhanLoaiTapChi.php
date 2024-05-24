<?php

namespace Database\Seeders;

use Carbon\Carbon;
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
                'ten' => 'Wos',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'abcd',
                'ten' => 'ABCD',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'aci',
                'ten' => 'ACI',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'quartile',
                'ten' => 'Scopus',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'abs',
                'ten' => 'ABS',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ]
        ];

        foreach($phanLoaiTapChis as $item){
            DB::table('d_m_phan_loai_tap_chi')->insert($item);
        }
    }
}
