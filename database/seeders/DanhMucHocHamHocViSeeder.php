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
                'name' => 'GS.TS',
                'fullname' => 'Giáo sư - Tiến sĩ'
            ],
            [
                'name' => 'PGS.TS',
                'fullname' => 'Phó Giáo sư - Tiến sĩ'
            ],
            [
                'name' => 'TS',
                'fullname' => 'Tiến sĩ'
            ],
            [
                'name' => 'ThS',
                'fullname' => 'Thạc sĩ'
            ],
            [
                'name' => 'CN',
                'fullname' => 'Cử nhân'
            ],
            [
                'name' => 'KS',
                'fullname' => 'Kỹ sư'
            ],
        );
    }
}
