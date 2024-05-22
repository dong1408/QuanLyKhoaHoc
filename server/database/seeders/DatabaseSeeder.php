<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DanhMucDonVi;
use Database\Seeders\DanhMucToChuc;
use Database\Seeders\DanhMucQuocGia;
use Database\Seeders\DanhMucTinhThanh;
use Database\Seeders\DanhMucPhanLoaiToChuc;
use Database\Seeders\DanhMucHocHamHocViSeeder;
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
        $this->call(DanhMucPhanLoaiToChuc::class);
        $this->call(DanhMucToChuc::class);
        $this->call(DanhMucDonVi::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserRoleSeeder::class);
        $this->call(RolePermissionSeeder::class);   
        $this->call(DanhMucSanPham::class);   
        $this->call(VaiTroTacGia::class);   
        // $this->call(NhaXuatBan::class);   
        // $this->call(TapChi::class);   
        // $this->call(DanhMucPhanLoaiTapChi::class);
    }
}
