<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NhaXuatBan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $nhaXuatBans = [
            [
                'name' => 'Emerald',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Biomedpress',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Taylors and Francis',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Elseviers',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'World Scientific Publishing',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Spriger',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'IOP Science',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'European Union Digital Library',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Viện Hàn Lâm Khoa học Việt Nam',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'Wiley-Black',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ],
            [
                'name' => 'IGI Global Publishing',
                'id_address_city' => '1',
                'id_address_country' => '1',              
            ]            
        ];

        foreach($nhaXuatBans as $item){
            DB::table('nha_xuat_bans')->insert($item);
        }
    }
}
