<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DanhMucSanPham extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dmSanPhams = [
            [
                'masanpham' => 'baibaokhoahoc',
                'tensanpham' => 'Bài báo khoa học',
                'mota' => 'bài báo khoa học'
            ],
            [
                'masanpham' => 'baocaokhoahoc',
                'tensanpham' => 'Báo cáo khoa học',
                'mota' => 'báo cáo khoa học'
            ],
            [
                'masanpham' => 'detai',
                'tensanpham' => 'Đề tài',
                'mota' => 'đề tài'
            ]
        ];

        foreach($dmSanPhams as $item){
            DB::table('d_m_san_phams')->insert($item);
        }
    }
}
