<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DMNganhTheoHDGSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dmNganhTheoHDGS = [
            [
                'ma' => 'CH',
                'ten' => 'Hội đồng giáo sư ngành Cơ học',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'CK-DL',
                'ten' => 'Hội đồng giáo sư liên ngành ngành Cơ khí - Động lực',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'CNTT',
                'ten' => 'Hội đồng giáo sư ngành Công nghệ thông tin',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'D-DT-TDH',
                'ten' => 'Hội đồng giáo sư liên ngành Điện - Điện tử - Tự động hoá',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'KHAN',
                'ten' => 'Hội đồng giáo sư ngành Khoa học An ninh',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'TH',
                'ten' => 'Hội đồng giáo sư ngành Toán học',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'VL',
                'ten' => 'Hội đồng giáo sư ngành Vật lý',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],
            [
                'ma' => 'YH',
                'ten' => 'Hội đồng giáo sư ngành Y học',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')              
            ],           
        ];

        foreach($dmNganhTheoHDGS as $item){
            DB::table('d_m_nganh_theo_hdgs')->insert($item);
        }
    }
}
