<?php

namespace Database\Seeders;

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
        DB::table('d_m_hoc_ham_hoc_vis')->insert(
            [
                'mahochamhocvi' => 'GS.TS',
                'tenhochamhocvi' => 'Giáo sư - Tiến sĩ'
            ],
            [
                'mahochamhocvi' => 'PGS.TS',
                'tenhochamhocvi' => 'Phó Giáo sư - Tiến sĩ'
            ],
            [
                'mahochamhocvi' => 'TS',
                'tenhochamhocvi' => 'Tiến sĩ'
            ],
            [
                'mahochamhocvi' => 'ThS',
                'tenhochamhocvi' => 'Thạc sĩ'
            ],
            [
                'name' => 'CN',
                'tenhochamhocvi' => 'Cử nhân'
            ],
            [
                'mahochamhocvi' => 'KS',
                'tenhochamhocvi' => 'Kỹ sư'
            ],
        );
    }
}
