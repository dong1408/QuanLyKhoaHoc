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
        DB::table('d_m_quoc_gias')->insert(
            [
                'maquocgia' => 'VN',
                'tenquocgia' => 'Việt Nam'
            ],
        );
    }
}
