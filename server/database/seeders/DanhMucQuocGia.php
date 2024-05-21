<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucQuocGia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $quocGias = [
            [
                'maquocgia' => 'VN',
                'tenquocgia' => 'Việt Nam'
            ],
            [
                'maquocgia' => 'US',
                'tenquocgia' => 'Hoa Kỳ'
            ],
            [
                'maquocgia' => 'GB',
                'tenquocgia' => 'Vương Quốc Anh'
            ]
        ];

        foreach($quocGias as $item){
            DB::table('d_m_quoc_gias')->insert($item);
        }
    }
}
