<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TapChi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tapChis = [
            [
                'name' => 'Journal of Asian Business and Economic Studies - JABES',
                'id_nhaxuatban' => '1',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Biomedical Research and Therapy',
                'id_nhaxuatban' => '2',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Progress in Stem Cell',
                'id_nhaxuatban' => '2',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Journal of Information and Telecommunication',
                'id_nhaxuatban' => '3',
                'trangthai' => '1',              
            ],
            [
                'name' => 'VNU Journal of Science: Advanced Materials and Devices',
                'id_nhaxuatban' => '4',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Vietnam Journal of Computer Science',
                'id_nhaxuatban' => '5',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Acta Mathematica Vietnamica',
                'id_nhaxuatban' => '6',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Vietnam Journal of Mathematics',
                'id_nhaxuatban' => '6',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Advances in Natural Sciences: Nanoscience and Nanotechnology',
                'id_nhaxuatban' => '7',
                'trangthai' => '1',              
            ],
            [
                'name' => '	EAI Endorsed Transactions on Industrial Networks and Intelligent Systems',
                'id_nhaxuatban' => '8',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Vietnam Journal of Earth Sciences',
                'id_nhaxuatban' => '9',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Vietnam Journal of Science and Technology',
                'id_nhaxuatban' => '9',
                'trangthai' => '1',              
            ],
            [
                'name' => 'Vietnam Journal of Chemistry',
                'id_nhaxuatban' => '10',
                'trangthai' => '1',              
            ],
            [
                'name' => 'International Journal of Knowledge and System Science',
                'id_nhaxuatban' => '11',
                'trangthai' => '1',              
            ]
        ];

        foreach($tapChis as $item){
            DB::table('tap_chis')->insert($item);
        }
    }
}
