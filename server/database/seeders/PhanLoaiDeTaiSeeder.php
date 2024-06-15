<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PhanLoaiDeTaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $phanLoaiDeTais = [
            [
                'maloai' => '',
                'tenloai' => 'Đề tài nghiên cứu khoa học cơ bản',
                'kinhphi' => '',
                'mota' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'maloai' => '',
                'tenloai' => 'Đề tài nghiên cứu ứng dụng',
                'kinhphi' => '',
                'mota' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'maloai' => '',
                'tenloai' => 'Đề tài nghiên cứu triển khai',
                'kinhphi' => '',
                'mota' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'maloai' => '',
                'tenloai' => 'Đề tài nghiên cứu thăm dò',
                'kinhphi' => '',
                'mota' => '',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ]
        ];

        foreach($phanLoaiDeTais as $item){
            DB::table('phan_loai_de_tais')->insert($item);
        }
    }
}
