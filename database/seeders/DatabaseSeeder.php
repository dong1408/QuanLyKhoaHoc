<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DanhMucDonVi;
use Database\Seeders\DanhMucQuocGia;
use Database\Seeders\DanhMucTinhThanh;
use Database\Seeders\DanhMucNoiCongTac;
use Database\Seeders\DanhMucHocHamHocViSeeder;
use Database\Seeders\DanhMucPhanLoaiNoiCongTac;
use Database\Seeders\DanhMucNgachVienChucSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(DanhMucHocHamHocViSeeder::class);
        $this->call(DanhMucNgachVienChucSeeder::class);
        $this->call(DanhMucQuocGia::class);
        $this->call(DanhMucTinhThanh::class);
        $this->call(DanhMucPhanLoaiNoiCongTac::class);
        $this->call(DanhMucDonVi::class);
        $this->call(DanhMucNoiCongTac::class);
        $this->call(UserSeeder::class);
        $this->call(DanhMucPhanLoaiTapChi::class);

    }
}
