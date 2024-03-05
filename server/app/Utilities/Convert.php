<?php

namespace App\Utilities;

use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\TapChi\DMNganhTheoHSGS;
use App\Models\TapChi\DMPhanLoaiTapChi;
use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Models\QuyDoi\DMNganhTinhDiem;
use App\Models\SanPham\DMSanPham;
use App\Models\TapChi\DMNganhTheoHDGS;
use App\Models\TapChi\TapChi;
use App\Models\TapChi\TapChiKhongCongNhan;
use App\Models\TapChi\TinhDiemTapChi;
use App\Models\TapChi\XepHangTapChi;
use App\Models\User;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMToChuc;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\SanPham\DMSanPhamVm;
use App\ViewModel\TapChi\NganhTheoHDGSVm;
use App\ViewModel\TapChi\PhanLoaiTapChiVm;
use App\ViewModel\TapChi\TapChiDetailVm;
use App\ViewModel\TapChi\TapChiKhongCongNhanVm;
use App\ViewModel\TapChi\TapChiVm;
use App\ViewModel\TapChi\TinhDiemTapChiVm;
use App\ViewModel\TapChi\XepHangTapChiVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;

class Convert
{

    // ========================= TAP CHI ============================= //

    public static function getTapChiVm(TapChi $tapChi): TapChiVm
    {
        $a = new TapChiVm();
        $a->id = $tapChi->id;
        $a->name = $tapChi->name;
        $a->address = $tapChi->address;
        $a->trangthai = $tapChi->trangthai;
        $a->nguoithem = Convert::getUserVm($tapChi->nguoiThem);
        $a->created_at = $tapChi->created_at;
        $a->updated_at = $tapChi->updated_at;
        return $a;
    }

    public static function getTapChiDetailVm(TapChi $tapChi): TapChiDetailVm
    {
        $a = new TapChiDetailVm();
        $a->id  = $tapChi->id;
        $a->name = $tapChi->name;
        $a->issn = $tapChi->issn;
        $a->eissn = $tapChi->eissn;
        $a->pissn = $tapChi->pissn;
        $a->website = $tapChi->website;
        $a->quocte = $tapChi->quocte;
        if (!$tapChi->nhaXuatBan) {
            $a->nhaxuatban = null;
        } else {
            $a->nhaxuatban = Convert::getNhaXuatBanVm($tapChi->nhaXuatBan); // $id_nhaxuatban
        }
        if (!$tapChi->donViChuQuan) {
            $a->donvichuquan = null;
        } else {
            $a->donvichuquan = Convert::getToChucVm($tapChi->donViChuQuan); // $id_donvichuquan -- ToChucVm
        }
        $a->address = $tapChi->id;
        if (!$tapChi->tinhThanh) {
            $a->addresscity = null;
        } else {
            $a->addresscity = Convert::getTinhThanhVm($tapChi->tinhThanh); // $id_address_city -- TinhThanhVM
        }
        if (!$tapChi->quocGia) {
            $a->addresscountry = null;
        } else {
            $a->addresscountry = Convert::getQuocGiaVm($tapChi->quocGia); // id_address_country -- QuocGiaVm
        }
        $a->trangthai = $tapChi->id;
        if (!$tapChi->nguoiThem) {
            $a->nguoithem = null;
        } else {
            $a->nguoithem = Convert::getUserVm($tapChi->nguoiThem); // $di_nguoithem -- UserVm
        }
        $a->created_at = $tapChi->id;
        $a->updated_at = $tapChi->id;

        $a->khongduoccongnhan = $tapChi->tapChiKhongCongNhans()->latest()->first()->khongduoccongnhan;

        $a->xephangtapchi = Convert::getXepHangTapChiVm($tapChi->xepHangTapChis()->latest()->first());
        $a->tinhdiemtapchi = Convert::getTinhDIemTapChiVm($tapChi->tinhDiemTapChis()->latest()->first());

        return $a;
    }

    public static function getTapChiKhongCongNhanVm(TapChiKhongCongNhan $tapChiKhongCongNhan): TapChiKhongCongNhanVm
    {
        $a = new TapChiKhongCongNhanVm();
        $a->id = $tapChiKhongCongNhan->id;
        $a->khongduoccongnhan = $tapChiKhongCongNhan->khongduoccongnhan;
        $a->ghichu = $tapChiKhongCongNhan->ghichu;
        $a->nguoicapnhat = Convert::getUserVm($tapChiKhongCongNhan->nguoicapnhat); //
        $a->created_at = $tapChiKhongCongNhan->created_at;
        $a->updated_at = $tapChiKhongCongNhan->updated_at;
        return $a;
    }

    public static function getNganhTheoHDGSVm(DMNganhTheoHDGS $dMNganhTheoHSGS): NganhTheoHDGSVm
    {
        $a = new NganhTheoHDGSVm();
        $a->id = $dMNganhTheoHSGS->id;
        $a->ma = $dMNganhTheoHSGS->ma;
        $a->ten = $dMNganhTheoHSGS->ten;
        $a->created_at = $dMNganhTheoHSGS->created_at;
        $a->updated_at = $dMNganhTheoHSGS->updated_at;
        return $a;
    }

    public static function getDMPhanLoaiTapChiVm(DMPhanLoaiTapChi $dMPhanLoaiTapChi): PhanLoaiTapChiVm
    {
        $a = new PhanLoaiTapChiVm();
        $a->id = $dMPhanLoaiTapChi->id;
        $a->ma = $dMPhanLoaiTapChi->ma;
        $a->ten = $dMPhanLoaiTapChi->ten;
        $a->created_at = $dMPhanLoaiTapChi->created_at;
        $a->updated_at = $dMPhanLoaiTapChi->updated_at;
        return $a;
    }

    public static function getTinhDIemTapChiVm(TinhDiemTapChi $tinhDiemTapChi): TinhDiemTapChiVm
    {
        $a = new TinhDiemTapChiVm();
        $a->id = $tinhDiemTapChi->id;
        // $a->tapchi = Convert::getTapChiVm($tinhDiemTapChi->tapChi);
        $a->nganhtinhdiem = Convert::getNganhTinhDiemVm($tinhDiemTapChi->nganhTinhDiem);
        $a->chuyennganhtinhdiem = Convert::getChuyenNganhTinhDiemVm($tinhDiemTapChi->chuyenNganhTinhDiem);
        $a->diem = $tinhDiemTapChi->diem;
        $a->namtinhdiem = $tinhDiemTapChi->namtinhdiem;
        $a->nguoicapnhat = Convert::getUserVm($tinhDiemTapChi->nguoiCapNhat);
        $a->ghichu = $tinhDiemTapChi->ghichu;
        $a->created_at = $tinhDiemTapChi->created_at;
        $a->updated_at = $tinhDiemTapChi->updated_at;
        return $a;
    }

    public static function getXepHangTapChiVm(XepHangTapChi $xepHangTapChi): XepHangTapChiVm
    {
        $a = new XepHangTapChiVm();
        $a->id = $xepHangTapChi->id;
        $a->tapchi = Convert::getTapChiVm($xepHangTapChi->tapChi);
        $a->wos = $xepHangTapChi->wos;
        $a->if = $xepHangTapChi->if;
        $a->quartile = $xepHangTapChi->quartile;
        $a->abs = $xepHangTapChi->abs;
        $a->abcd = $xepHangTapChi->abcd;
        $a->aci = $xepHangTapChi->aci;
        $a->ghichu = $xepHangTapChi->ghichu;
        if (!$xepHangTapChi->user) {
            $a->user = null;
        } else {
            $a->user = Convert::getUserVm($xepHangTapChi->user);
        }
        $a->created_at = $xepHangTapChi->created_at;
        $a->updated_at = $xepHangTapChi->updated_at;
        return $a;
    }


    // ========================= USER ============================= //

    public static function getUserVm(User $user): UserVm
    {
        $a = new UserVm();
        $a->id = $user->id;
        $a->name = $user->name;
        $a->username = $user->username;
        $a->email = $user->email;
        return $a;
    }

    public static function getToChucVm(DMToChuc $dMToChuc)
    {
        $a = new ToChucVm();
        $a->id = $dMToChuc->id;
        $a->matochuc = $dMToChuc->matochuc;
        $a->tentochuc = $dMToChuc->tentochuc;
        $a->tentochuc_en = $dMToChuc->tentochuc_en;
        return $a;
    }

    public static function getTinhThanhVm(DMTinhThanh $dmTinhThanh)
    {
        $a = new TinhThanhVm();
        $a->id = $dmTinhThanh->id;
        $a->matinhthanh = $dmTinhThanh->matinhthanh;
        $a->tentinhthanh = $dmTinhThanh->tentinhthanh;
        $a->tentinhthanh_en = $dmTinhThanh->tentinhthanh_en;
        return $a;
    }

    public static function getTinhThanhDetailVm(DMTinhThanh $dmTinhThanh)
    {
        $a = new TinhThanhVm();
        $a->id = $dmTinhThanh->id;
        $a->quocgia = Convert::getQuocGiaVm($dmTinhThanh->quocGia);
        $a->matinhthanh = $dmTinhThanh->matinhthanh;
        $a->tentinhthanh = $dmTinhThanh->tentinhthanh;
        $a->tentinhthanh_en = $dmTinhThanh->tentinhthanh_en;
        return $a;
    }

    public static function getQuocGiaVm(DMQuocGia $dMQuocGia)
    {
        $a = new QuocGiaVm();
        $a->id = $dMQuocGia->id;
        $a->maquocgia = $dMQuocGia->maquocgia;
        $a->tenquocgia = $dMQuocGia->tenquocgia;
        $a->tenquocgia_en = $dMQuocGia->tenquocgia_en;
        return $a;
    }

    // ========================= SAN PHAM ============================= //

    public static function getDMSanPhamVm(DMSanPham $dmSanPham): DMSanPhamVm
    {
        $a = new DMSanPhamVm();
        $a->id = $dmSanPham->id;
        $a->madmsanpham = $dmSanPham->madmsanpham;
        $a->tendmsanpham = $dmSanPham->tensanpham;
        $a->mota = $dmSanPham->mota;
        $a->created_at = $dmSanPham->created_at;
        $a->updated_at = $dmSanPham->updated_at;
        return $a;
    }

    // ========================= BAI BAO ============================= //


    // ========================= DE TAI ============================= //


    // ========================= QUY DOI ============================= //

    public static function getNganhTinhDiemVm(DMNganhTinhDiem $dMNganhTinhDiem): NganhTinhDiemVm
    {
        $a = new NganhTinhDiemVm();
        $a->id = $dMNganhTinhDiem->id;
        $a->manganhtinhdiem = $dMNganhTinhDiem->manganhtinhdiem;
        $a->tennganhtinhdiem = $dMNganhTinhDiem->tennganhtinhdiem;
        $a->tennganh_en = $dMNganhTinhDiem->tennganh_en;
        $a->created_at = $dMNganhTinhDiem->created_at;
        $a->updated_at = $dMNganhTinhDiem->updated_at;
        return $a;
    }

    public static function getChuyenNganhTinhDiemVm(DMChuyenNganhTinhDiem $dmChuyenNganhTinhDiem): ChuyenNganhTinhDiemVm
    {
        $a = new ChuyenNganhTinhDiemVm();
        $a->id = $dmChuyenNganhTinhDiem->id;
        $a->nganhtinhdiem = Convert::getNganhTinhDiemVm($dmChuyenNganhTinhDiem->nganhTinhDiem);
        $a->machuyennganh = $dmChuyenNganhTinhDiem->machuyennganh;
        $a->tenchuyennganh = $dmChuyenNganhTinhDiem->tenchuyennganh;
        $a->tenchuyennganh_en = $dmChuyenNganhTinhDiem->tenchuyennganh_en;
        $a->created_at = $dmChuyenNganhTinhDiem->created_at;
        $a->updated_at = $dmChuyenNganhTinhDiem->updated_at;
        return $a;
    }

    // ========================= NHA XUAT BAN ============================= //
    public static function getNhaXuatBanVm(NhaXuatBan $nhaXuatBan)
    {
        $a = new NhaXuatBanVm();
        $a->id = $nhaXuatBan->id;
        $a->name = $nhaXuatBan->name;
        return $a;
    }
}
