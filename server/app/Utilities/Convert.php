<?php

namespace App\Utilities;

use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\TapChi\DMNganhTheoHSGS;
use App\Models\TapChi\DMPhanLoaiTapChi;
use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Models\QuyDoi\DMNganhTinhDiem;
use App\Models\SanPham\DMSanPham;
use App\Models\SanPham\DMVaiTroTacGia;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\TapChi\DMNganhTheoHDGS;
use App\Models\TapChi\TapChi;
use App\Models\TapChi\TapChiKhongCongNhan;
use App\Models\TapChi\TinhDiemTapChi;
use App\Models\TapChi\XepHangTapChi;
use App\Models\User;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMToChuc;
use App\ViewModel\BaiBao\BaiBaoKhoaHocDetailVm;
use App\ViewModel\BaiBao\BaiBaoKhoaHocVm;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\SanPham\DMSanPhamVm;
use App\ViewModel\SanPham\SanPhamDetailVm;
use App\ViewModel\SanPham\SanPhamTacGiaVm;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\SanPham\VaiTroTacGiaVm;
use App\ViewModel\TapChi\NganhTheoHDGSVm;
use App\ViewModel\TapChi\PhanLoaiTapChiVm;
use App\ViewModel\TapChi\TapChiDetailVm;
use App\ViewModel\TapChi\TapChiKhongCongNhanDetailVm;
use App\ViewModel\TapChi\TapChiKhongCongNhanVm;
use App\ViewModel\TapChi\TapChiVm;
use App\ViewModel\TapChi\TinhDiemTapChiDetailVm;
use App\ViewModel\TapChi\TinhDiemTapChiVm;
use App\ViewModel\TapChi\XepHangTapChiDetailVm;
use App\ViewModel\TapChi\XepHangTapChiVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaDetailVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhDetailVm;
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
        $a->khongduoccongnhan = optional($tapChi->tapChiKhongCongNhans()->latest()->first())->khongduoccongnhan ?? null;
        if ($tapChi->nguoiThem == null) {
            $a->nguoithem = null;
        } else {
            $a->nguoithem = Convert::getUserVm($tapChi->nguoiThem);
        }
        $a->created_at = $tapChi->created_at;
        $a->updated_at = $tapChi->updated_at;
        $a->deleted_at = $tapChi->deleted_at;
        $a->issn = $tapChi->issn;
        $a->pissn = $tapChi->pissn;
        $a->eissn = $tapChi->eissn;
        $a->quocte = $tapChi->quocte;
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
        $a->address = $tapChi->address;
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
        $a->trangthai = $tapChi->trangthai;
        if (!$tapChi->nguoiThem) {
            $a->nguoithem = null;
        } else {
            $a->nguoithem = Convert::getUserVm($tapChi->nguoiThem); // $di_nguoithem -- UserVm
        }
        $a->created_at = $tapChi->id;
        $a->updated_at = $tapChi->id;

        if ($tapChi->tapChiKhongCongNhans()->latest()->first() == null) {
            $a->khongduoccongnhan = null;
        } else {
            $a->khongduoccongnhan = Convert::getTapChiKhongCongNhanVm($tapChi->tapChiKhongCongNhans()->latest()->first());
        }
        if ($tapChi->xepHangTapChis()->latest()->first() == null) {
            $a->xephangtapchi = null;
        } else {
            $a->xephangtapchi = Convert::getXepHangTapChiVm($tapChi->xepHangTapChis()->latest()->first());
        }
        if ($tapChi->tinhDiemTapChis()->latest()->first() == null) {
            $a->tinhdiemtapchi = null;
        } else {
            $a->tinhdiemtapchi = Convert::getTinhDIemTapChiVm($tapChi->tinhDiemTapChis()->latest()->first());
        }

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

    public static function getTapChiKhongCongNhanVm(TapChiKhongCongNhan $tapChiKhongCongNhan): TapChiKhongCongNhanVm
    {
        $a = new TapChiKhongCongNhanVm();
        $a->id = $tapChiKhongCongNhan->id;
        $a->khongduoccongnhan = $tapChiKhongCongNhan->khongduoccongnhan;
        $a->created_at = $tapChiKhongCongNhan->created_at;
        $a->updated_at = $tapChiKhongCongNhan->updated_at;
        $a->nguoicapnhat = Convert::getUserVm($tapChiKhongCongNhan->nguoicapnhat);
        $a->ghichu = $tapChiKhongCongNhan->ghichu;
        return $a;
    }

    public static function getTinhDIemTapChiVm(TinhDiemTapChi $tinhDiemTapChi): TinhDiemTapChiVm
    {
        $a = new TinhDiemTapChiVm();
        $a->id = $tinhDiemTapChi->id;
        $a->ghichu = $tinhDiemTapChi->ghichu;
        $a->diem = $tinhDiemTapChi->diem;
        $a->namtinhdiem = $tinhDiemTapChi->namtinhdiem;
        $a->created_at = $tinhDiemTapChi->created_at;
        $a->updated_at = $tinhDiemTapChi->updated_at;
        $a->nguoicapnhat = Convert::getUserVm($tinhDiemTapChi->nguoicapnhat);
        if ($tinhDiemTapChi->nganhTinhDiem == null) {
            $a->nganhtinhdiem = null;
        } else {
            $a->nganhtinhdiem = Convert::getNganhTinhDiemVm($tinhDiemTapChi->nganhTinhDiem);
        }
        if ($tinhDiemTapChi->chuyenNganhTinhDiem == null) {
            $a->nganhtinhdiem = null;
        } else {
            $a->chuyennganhtinhdiem = Convert::getChuyenNganhTinhDiemVm($tinhDiemTapChi->chuyenNganhTinhDiem);
        }
        return $a;
    }

    public static function getXepHangTapChiVm(XepHangTapChi $xepHangTapChi): XepHangTapChiVm
    {
        $a = new XepHangTapChiVm();
        $a->id = $xepHangTapChi->id;
        $a->wos = $xepHangTapChi->wos;
        $a->if = $xepHangTapChi->if;
        $a->quartile = $xepHangTapChi->quartile;
        $a->abs = $xepHangTapChi->abs;
        $a->abcd = $xepHangTapChi->abcd;
        $a->aci = $xepHangTapChi->aci;
        $a->ghichu = $xepHangTapChi->ghichu;
        $a->created_at = $xepHangTapChi->created_at;
        $a->updated_at = $xepHangTapChi->updated_at;
        if (!$xepHangTapChi->user) {
            $a->nguoicapnhat = null;
        } else {
            $a->nguoicapnhat = Convert::getUserVm($xepHangTapChi->user);
        }
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
        $a->tentochuc = $dMToChuc->tentochuc;
        $a->created_at = $dMToChuc->created_at;
        $a->dienthoai = $dMToChuc->dienthoai;
        $a->matochuc = $dMToChuc->matochuc;
        $a->tentochuc_en = $dMToChuc->tentochuc_en;
        $a->updated_at = $dMToChuc->updated_at;
        $a->website = $dMToChuc->website;
        return $a;
    }

    public static function getTinhThanhVm(DMTinhThanh $dmTinhThanh)
    {
        $a = new TinhThanhVm();
        $a->id = $dmTinhThanh->id;
        $a->tentinhthanh = $dmTinhThanh->tentinhthanh;
        return $a;
    }

    public static function getTinhThanhDetailVm(DMTinhThanh $dmTinhThanh)
    {
        $a = new TinhThanhDetailVm();
        $a->id = $dmTinhThanh->id;
        if ($dmTinhThanh->quocGia == null) {
            $dmTinhThanh = null;
        } else {
            $a->quocgia = Convert::getQuocGiaVm($dmTinhThanh->quocGia);
        }
        $a->matinhthanh = $dmTinhThanh->matinhthanh;
        $a->tentinhthanh = $dmTinhThanh->tentinhthanh;
        $a->tentinhthanh_en = $dmTinhThanh->tentinhthanh_en;
        return $a;
    }

    public static function getQuocGiaVm(DMQuocGia $dMQuocGia)
    {
        $a = new QuocGiaVm();
        $a->id = $dMQuocGia->id;
        $a->tenquocgia = $dMQuocGia->tenquocgia;
        return $a;
    }

    public static function getQuocGiaDetailVm(DMQuocGia $dMQuocGia)
    {
        $a = new QuocGiaDetailVm();
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
        $a->tendmsanpham = $dmSanPham->tensanpham;
        $a->created_at = $dmSanPham->created_at;
        $a->updated_at = $dmSanPham->updated_at;
        return $a;
    }

    public static function getSanPhamVm(SanPham $sanPham)
    {
        $a = new SanPhamVm();
        $a->id = $sanPham->id;
        $a->tensanpham = $sanPham->tensanpham;
        $a->loaisanpham = Convert::getDMSanPhamVm($sanPham->dmSanPham);
        $a->tongsotacgia = $sanPham->tongsotacgia;
        $a->solandaquydoi = $sanPham->solanquydoi;
        if ($sanPham->nguoiKeKhai == null) {
            $a->nguoikekhai = null;
        } else {
            $a->nguoikekhai = Convert::getUserVm($sanPham->nguoiKeKhai);
        }
        $a->diemquydoi = $sanPham->diemquydoi;
        $a->gioquydoi = $sanPham->gioquydoi;
        $a->capsanpham = $sanPham->capsanpham;
        $a->thoidiemcongbohoanthanh = $sanPham->thoidiemhoanthanh;
        $a->created_at = $sanPham->created_at;
        $a->updated_at = $sanPham->updated_at;

        return $a;
    }

    public static function getSanPhamDetailVm(SanPham $sanPham)
    {
        $a = new SanPhamDetailVm();
        $a->id = $sanPham->id;
        $a->tensanpham = $sanPham->tensanpham;
        if ($sanPham->dmSanPham == null) {
            $a->loaisanpham = null;
        } else {
            $a->loaisanpham = Convert::getDMSanPhamVm($sanPham->dmSanPham);
        }
        $a->tongsotacgia = $sanPham->tongsotacgia;
        $a->solandaquydoi = $sanPham->solandaquydoi;
        $a->cosudungemailtruong = $sanPham->cosudungemailtruong;
        $a->cosudungemaildonvikhac = $sanPham->cosudungemaildonvikhac;
        $a->cothongtintruong = $sanPham->cothongtintruong;
        $a->cothongtindonvikhac = $sanPham->cothongtindonvikhac;
        if ($sanPham->thongTinNoiKhac == null) {
            $a->thongtinnoikhac = null;
        } else {
            $a->thongtinnoikhac = Convert::getToChucVm($sanPham->thongTinNoiKhac);
        }

        $a->conhantaitro = $sanPham->conhantaitro;
        if ($sanPham->donViTaiTro == null) {
            $a->donvitaitro = null;
        } else {
            $a->donvitaitro = Convert::getToChucVm($sanPham->donViTaiTro);
        }
        $a->chitietdonvitaitro = $sanPham->chitietdonvitaitro;
        $a->ngaykekhai = $sanPham->ngaykekhai;
        if ($sanPham->nguoiKeKhai == null) {
            $a->nguoikekhai = null;
        } else {
            $a->nguoikekhai = Convert::getUserVm($sanPham->nguoiKeKhai);
        }

        $a->trangthairasoat = $sanPham->trangthairasoat;
        $a->ngayrasoat = $sanPham->ngayrasoat;
        if ($sanPham->nguoiRaSoat == null) {
            $a->nguoirasoat = null;
        } else {
            $a->nguoirasoat = Convert::getUserVm($sanPham->nguoiRaSoat);
        }

        $a->diemquydoi = $sanPham->diemquydoi;
        $a->gioquydoi = $sanPham->gioquydoi;
        $a->thongtinchitiet = $sanPham->thongtinchitiet;
        $a->capsanpham = $sanPham->capsanpham;
        $a->thoidiemcongbohoanthanh = $sanPham->thoidiemcongbohoanthanh;
        $a->created_at = $sanPham->created_at;
        $a->updated_at = $sanPham->updated_at;

        foreach ($sanPham->sanPhamsTacGias() as $sanPhaMTacGia) {
            $a->sanpham_tacgia[] = $sanPhaMTacGia;
        }
        return $a;
    }

    public static function getVaiTroTacGiaVm(DMVaiTroTacGia $dMVaiTroTacGia)
    {
        $a = new VaiTroTacGiaVm();
        $a->id = $dMVaiTroTacGia->id;
        $a->tenvaitro = $dMVaiTroTacGia->tenvaitro;
        return $a;
    }

    public static function getSanPhamTacGiaVm(SanPhamTacGia $sanPhaMTacGia)
    {
        $a = new SanPhamTacGiaVm();
        $a->id = $sanPhaMTacGia->id;
        if ($sanPhaMTacGia->sanPham == null) {
            $sanPhaMTacGia = null;
        } else {
            $a->sanpham = Convert::getSanPhamVm($sanPhaMTacGia->sanPham);
        }
        if ($sanPhaMTacGia->tacGia == null) {
            $a->tacgia = null;
        } else {
            $a->tacgia = Convert::getUserVm($sanPhaMTacGia->tacGia);
        }
        if ($sanPhaMTacGia->vaiTroTacGia == null) {
            $a->vaitrotacgia = null;
        } else {
            $a->vaitrotacgia = Convert::getVaiTroTacGiaVm($sanPhaMTacGia->vaiTroTacGia);
        }
        $a->thutu = $sanPhaMTacGia->thutu;
        $a->tyledonggop = $sanPhaMTacGia->tyledonggop;
        $a->created_at = $sanPhaMTacGia->created_at;
        $a->updated_at = $sanPhaMTacGia->updated_at;

        return $a;
    }


    // ========================= BAI BAO ============================= //

    public static function getBaiBaoKhoaHocVm(BaiBaoKhoaHoc $baiBaoKhoaHoc)
    {
        $a = new BaiBaoKhoaHocVm();
        $a->id = $baiBaoKhoaHoc->id;
        if ($baiBaoKhoaHoc->sanPham == null) {
            $a->tensanpham = null;
            $a->id_sanpham = null;
        } else {
            $a->id_sanpham = $baiBaoKhoaHoc->sanPham->id;
            $a->tensanpham = $baiBaoKhoaHoc->sanPham->tensanpham;
        }
        $a->keywords = $baiBaoKhoaHoc->keyword;
        if ($baiBaoKhoaHoc->tapChi == null) {
            $a->tentapchi = null;
        } else {
            $a->tentapchi = $baiBaoKhoaHoc->tapChi->name;
        }
        $a->volume = $baiBaoKhoaHoc->volume;
        $a->issue = $baiBaoKhoaHoc->issue;
        $a->number = $baiBaoKhoaHoc->number;
        $a->pages = $baiBaoKhoaHoc->pages;
        $a->created_at = $baiBaoKhoaHoc->created_at;
        
        $a->updated_at = $baiBaoKhoaHoc->updated_at;

        return $a;
    }

    public static function getBaiBaoKhoaHocDetailVm(BaiBaoKhoaHoc $baiBaoKhoaHoc)
    {
        $a = new BaiBaoKhoaHocDetailVm();
        $a->id = $baiBaoKhoaHoc->id;
        if ($baiBaoKhoaHoc->sanPham == null) {
            $a->sanpham = null;
        } else {
            $a->sanpham = Convert::getSanPhamDetailVm($baiBaoKhoaHoc->sanPham);
        }
        $a->doi = $baiBaoKhoaHoc->doi;
        $a->url = $baiBaoKhoaHoc->url;
        $a->received = $baiBaoKhoaHoc->received;
        $a->accepted = $baiBaoKhoaHoc->accepted;
        $a->published = $baiBaoKhoaHoc->published;
        $a->abstract = $baiBaoKhoaHoc->abstract;
        $a->keywords = $baiBaoKhoaHoc->keywords;
        if ($baiBaoKhoaHoc->tapChi == null) {
            $a->tapchi = null;
        } else {
            $a->tapchi = Convert::getTapChiVm($baiBaoKhoaHoc->tapChi);
        }
        $a->volume = $baiBaoKhoaHoc->volume;
        $a->issue = $baiBaoKhoaHoc->issue;
        $a->number = $baiBaoKhoaHoc->number;
        $a->pages = $baiBaoKhoaHoc->pages;
        $a->created_at = $baiBaoKhoaHoc->created_at;
        $a->updated_at = $baiBaoKhoaHoc->updated_at;

        foreach ($baiBaoKhoaHoc->sanPham->sanPhamsTacGias as $sanPhaMTacGia) {
            $a->sanpham_tacgias[] = Convert::getSanPhamTacGiaVm($sanPhaMTacGia);
            // $a->sanpham_tacgias[] = $sanPhaMTacGia;
        }
        return $a;
    }


    // ========================= DE TAI ============================= //


    // ========================= QUY DOI ============================= //

    public static function getNganhTinhDiemVm(DMNganhTinhDiem $dMNganhTinhDiem): NganhTinhDiemVm
    {
        $a = new NganhTinhDiemVm();
        $a->id = $dMNganhTinhDiem->id;
        $a->tennganhtinhdiem = $dMNganhTinhDiem->tennganhtinhdiem;
        $a->created_at = $dMNganhTinhDiem->created_at;
        $a->updated_at = $dMNganhTinhDiem->updated_at;
        $a->manganhtinhdiem = $dMNganhTinhDiem->manganhtinhdiem;
        $a->tennganh_en = $dMNganhTinhDiem->tennganh_en;
        return $a;
    }

    public static function getChuyenNganhTinhDiemVm(DMChuyenNganhTinhDiem $dmChuyenNganhTinhDiem): ChuyenNganhTinhDiemVm
    {
        $a = new ChuyenNganhTinhDiemVm();
        $a->id = $dmChuyenNganhTinhDiem->id;
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
        $a->quocte = $nhaXuatBan->quocte;
        $a->isbn = $nhaXuatBan->isbn;
        $a->website = $nhaXuatBan->website;
        return $a;
    }
}
