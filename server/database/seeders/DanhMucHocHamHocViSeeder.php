<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DanhMucHocHamHocViSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dmHocHamHocVis = [
            [
                'mahochamhocvi' => 'GS.TS',
                'tenhochamhocvi' => 'Giáo sư - Tiến sĩ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahochamhocvi' => 'PGS.TS',
                'tenhochamhocvi' => 'Phó Giáo sư - Tiến sĩ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahochamhocvi' => 'TS',
                'tenhochamhocvi' => 'Tiến sĩ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahochamhocvi' => 'ThS',
                'tenhochamhocvi' => 'Thạc sĩ',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahochamhocvi' => 'CN',
                'tenhochamhocvi' => 'Cử nhân',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'mahochamhocvi' => 'KS',
                'tenhochamhocvi' => 'Kỹ sư',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ];

        foreach($dmHocHamHocVis as $item){
            DB::table('d_m_hoc_ham_hoc_vis')->insert($item);
        }    
    }
}
