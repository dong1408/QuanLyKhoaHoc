<?php

namespace App\Utilities;

use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\DeTai\BaoCaoTienDo;
use App\Models\DeTai\DeTai;
use App\Models\DeTai\NghiemThu;
use App\Models\DeTai\PhanLoaiDeTai;
use App\Models\DeTai\TuyenChon;
use App\Models\DeTai\XetDuyet;
use App\Models\FileMinhChungSanPham;
use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\TapChi\DMNganhTheoHSGS;
use App\Models\TapChi\DMPhanLoaiTapChi;
use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Models\QuyDoi\DMNganhTinhDiem;
use App\Models\Role;
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
use App\Models\UserInfo\DMChuyenMon;
use App\Models\UserInfo\DMDonVi;
use App\Models\UserInfo\DMHocHamHocVi;
use App\Models\UserInfo\DMNgachVienChuc;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMToChuc;
use App\ViewModel\BaiBao\BaiBaoKhoaHocDetailVm;
use App\ViewModel\BaiBao\BaiBaoKhoaHocVm;
use App\ViewModel\DeTai\BaoCaoTienDoVm;
use App\ViewModel\DeTai\DeTaiDetailVm;
use App\ViewModel\DeTai\DeTaiVm;
use App\ViewModel\DeTai\NghiemThuVm;
use App\ViewModel\DeTai\PhanLoaiDeTaiVm;
use App\ViewModel\DeTai\TuyenChonVm;
use App\ViewModel\DeTai\XetDuyetVm;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\RolePermission\PermissionBySlugVm;
use App\ViewModel\RolePermission\RoleVm;
use App\ViewModel\SanPham\DMSanPhamVm;
use App\ViewModel\SanPham\FileMinhChungSanPhamVm;
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
use App\ViewModel\User\UserDetailVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\ChuyenMonVm;
use App\ViewModel\UserInfo\DonViVm;
use App\ViewModel\UserInfo\HocHamHocViVm;
use App\ViewModel\UserInfo\NgachVienChucVm;
use App\ViewModel\UserInfo\QuocGiaDetailVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhDetailVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use Illuminate\Database\Eloquent\Collection;

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
        $a->created_at = $tapChi->created_at ?? null;
        $a->updated_at = $tapChi->updated_at ?? null;
        $a->deleted_at = $tapChi->deleted_at ?? null;
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
        $a->deleted_at = $tapChi->deleted_at ?? null;

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

    public static function getUserDetailVm(User $user)
    {
        $a = new UserDetailVm();
        $a->id = $user->id;
        $a->name = $user->name;
        $a->username = $user->username;
        $a->email = $user->email;
        $a->role = $user->role;
        $a->changed = $user->changed ?? null;
        $a->ngaysinh = $user->ngaysinh ?? null;
        $a->dienthoai = $user->dienthoai ?? null;
        $a->email2 = $user->email2 ?? null;
        $a->orchid = $user->orchid ?? null;
        $a->tochuc = $user->toChuc == null ? null : Convert::getToChucVm($user->toChuc);
        $a->donvi = $user->donVi == null ? null : Convert::getDonViVm($user->donVi);
        $a->cohuu = $user->cohuu ?? null;
        $a->keodai = $user->keodai ?? null;
        $a->dinhmucnghiavunckh = $user->dinhmucnghiavunckh ?? null;
        $a->dangdihoc = $user->dangdihoc ?? null;
        $a->noihoc = $user->noiHoc == null ? null : Convert::getToChucVm($user->noihoc);
        $a->ngachvienchuc = $user->ngachVienChuc == null ? null : Convert::getNgachVienChucVm($user->ngachVienChuc);
        $a->quoctich = $user->quocGia == null ? null : Convert::getQuocGiaVm($user->quocGia);
        $a->hochamhocvi = $user->hocHamHocVi == null ? null : Convert::getHocHamHocViVm($user->hocHamHocVi);
        $a->chuyenmon = $user->chuyenMon == null ? null : Convert::getChuyenMonVm($user->chuyenMon);
        $a->nganhtinhdiem = $user->nganhTinhDiem == null ? null : Convert::getNganhTinhDiemVm($user->nganhTinhDiem);
        $a->chuyennganhtinhdiem = $user->chuyenNganhTinhDiem == null ? null : Convert::getChuyenNganhTinhDiemVm($user->chuyenNganhTinhDiem);
        $a->created_at = $user->created_at;
        $a->updated_at = $user->updated_at;

        return $a;
    }


    // ========================= USER INFO ============================= //

    public static function getToChucVm(DMToChuc $dMToChuc)
    {
        $a = new ToChucVm();
        $a->id = $dMToChuc->id;
        $a->tentochuc = $dMToChuc->tentochuc ?? null;
        $a->created_at = $dMToChuc->created_at ?? null;
        $a->dienthoai = $dMToChuc->dienthoai ?? null;
        $a->matochuc = $dMToChuc->matochuc ?? null;
        $a->tentochuc_en = $dMToChuc->tentochuc_en ?? null;
        $a->updated_at = $dMToChuc->updated_at ?? null;
        $a->website = $dMToChuc->website ?? null;
        return $a;
    }

    public static function getTinhThanhVm(DMTinhThanh $dmTinhThanh)
    {
        $a = new TinhThanhVm();
        $a->id = $dmTinhThanh->id;
        $a->tentinhthanh = $dmTinhThanh->tentinhthanh ?? null;
        $a->matinhthanh = $dmTinhThanh->matinhthanh ?? null;
        $a->tentinhthanh_en = $dmTinhThanh->tentinhthanh_en ?? null;
        return $a;
    }


    public static function getQuocGiaVm(DMQuocGia $dMQuocGia)
    {
        $a = new QuocGiaVm();
        $a->id = $dMQuocGia->id;
        $a->tenquocgia = $dMQuocGia->tenquocgia ?? null;
        $a->maquocgia = $dMQuocGia->maquocgia ?? null;
        $a->tenquocgia_en = $dMQuocGia->tenquocgia_en ?? null;
        $a->created_at = $dMQuocGia->created_at ?? null;
        $a->updated_at = $dMQuocGia->updated_at ?? null;
        return $a;
    }

    public static function getDonViVm(DMDonVi $dMDonVi)
    {
        $a = new DonViVm();
        $a->id = $dMDonVi->id;
        $a->tendonvi = $dMDonVi->tendonvi ?? null;
        $a->created_at = $dMDonVi->created_at ?? null;
        $a->updated_at = $dMDonVi->updated_at ?? null;
        return $a;
    }

    public static function getNgachVienChucVm(DMNgachVienChuc $dMNgachVienChuc)
    {
        $a = new NgachVienChucVm();
        $a->id = $dMNgachVienChuc->id;
        $a->tenngach = $dMNgachVienChuc->tenngach ?? null;
        $a->created_at = $dMNgachVienChuc->created_at ?? null;
        $a->updated_at = $dMNgachVienChuc->updated_at ?? null;
        return $a;
    }

    public static function getHocHamHocViVm(DMHocHamHocVi $dMHocHamHocVi)
    {
        $a = new HocHamHocViVm();
        $a->id = $dMHocHamHocVi->id;
        $a->tenhochamhocvi = $dMHocHamHocVi->tenhochamhocvi ?? null;
        $a->created_at = $dMHocHamHocVi->created_at ?? null;
        $a->updated_at = $dMHocHamHocVi->updated_at ?? null;
        return $a;
    }

    public static function getChuyenMonVm(DMChuyenMon $dMChuyenMon)
    {
        $a = new ChuyenMonVm();
        $a->id = $dMChuyenMon->id;
        $a->tenchuyenmon = $dMChuyenMon->tenchuyenmon ?? null;
        $a->created_at = $dMChuyenMon->created_at ?? null;
        $a->updated_at = $dMChuyenMon->updated_at ?? null;
        return $a;
    }

    // ========================= ROLE PERMISSION ====================== //
    public static function getRoleVm(Role $role)
    {
        $a = new RoleVm();
        $a->id = $role->id;
        $a->name = $role->name;
        $a->description = $role->description;
        $a->created_at = $role->created_at;
        $a->updated_at = $role->updated_at;
        return $a;
    }


    public static function getPermissionsBySlugVm(Collection $collection)
    {
        $result = [];
        foreach ($collection as $prefixSlug => $permissions) {
            $a = new PermissionBySlugVm();
            $a->prefixSlug = $prefixSlug;
            foreach ($permissions as $permission) {
                $a->permissions[] = $permission;
            }
            $result[] = $a;
        }
        return $result;
    }




    // ========================= SAN PHAM ============================= //

    public static function getDMSanPhamVm(DMSanPham $dmSanPham): DMSanPhamVm
    {
        $a = new DMSanPhamVm();
        $a->id = $dmSanPham->id;
        $a->tendmsanpham = $dmSanPham->tensanpham ?? null;
        $a->created_at = $dmSanPham->created_at;
        $a->updated_at = $dmSanPham->updated_at;
        $a->madmsanpham = $dmSanPham->masanpham ?? null;
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
        $a->chitietdonvitaitro = $sanPham->chitietdonvitaitro ?? null;
        $a->ngaykekhai = $sanPham->ngaykekhai;
        if ($sanPham->nguoiKeKhai == null) {
            $a->nguoikekhai = null;
        } else {
            $a->nguoikekhai = Convert::getUserVm($sanPham->nguoiKeKhai);
        }

        $a->trangthairasoat = $sanPham->trangthairasoat;
        $a->ngayrasoat = $sanPham->ngayrasoat ?? null;
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
        if ($sanPham->fileMinhChung == null) {
            $a->minhchung = null;
        } else {
            $a->minhchung = Convert::getFileMinhChungSanPhamVm($sanPham->fileMinhChung);
        }
        $a->created_at = $sanPham->created_at;
        $a->updated_at = $sanPham->updated_at;
        $a->deleted_at = $sanPham->deleted_at ?? null;
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
        $a->tenvaitro_en = $dMVaiTroTacGia->tenvaitro_en ?? null;
        $a->mavaitro = $dMVaiTroTacGia->mavaitro;
        $a->role = $dMVaiTroTacGia->role;
        return $a;
    }

    public static function getSanPhamTacGiaVm(SanPhamTacGia $sanPhaMTacGia)
    {
        $a = new SanPhamTacGiaVm();
        $a->id = $sanPhaMTacGia->id;
        $a->tacgia = Convert::getUserVm($sanPhaMTacGia->tacGia);
        $a->vaitrotacgia = Convert::getVaiTroTacGiaVm($sanPhaMTacGia->vaiTroTacGia);

        $a->thutu = $sanPhaMTacGia->thutu ?? null;
        $a->tyledonggop = $sanPhaMTacGia->tyledonggop  ?? null;
        $a->created_at = $sanPhaMTacGia->created_at;
        $a->updated_at = $sanPhaMTacGia->updated_at;

        return $a;
    }


    public static function getFileMinhChungSanPhamVm(FileMinhChungSanPham $fileMinhChungSanPham)
    {
        $a = new FileMinhChungSanPhamVm();
        $a->id = $fileMinhChungSanPham->id;
        $a->loaiminhchung = $fileMinhChungSanPham->loaiminhchung ?? null;
        $a->url = $fileMinhChungSanPham->url ?? null;
        $a->created_at = $fileMinhChungSanPham->created_at ?? null;
        $a->updated_at = $fileMinhChungSanPham->deleted_at ?? null;
        return $a;
    }



    // ========================= BAI BAO ============================= //

    public static function getBaiBaoKhoaHocVm(SanPham $sanPham)
    {
        $a = new BaiBaoKhoaHocVm();
        $a->id = $sanPham->baiBao->id;
        $a->id_sanpham = $sanPham->id;
        $a->tensanpham = $sanPham->tensanpham;
        $a->keywords = $sanPham->baiBao->keyword ?? null;
        $a->tentapchi = $sanPham->baiBao->tapChi == null ? $a->tentapchi = null : $sanPham->baiBao->tapChi->name;
        $a->volume = $sanPham->baiBao->volume ?? null;
        $a->issue = $sanPham->baiBao->issue ?? null;
        $a->number = $sanPham->baiBao->number ?? null;
        $a->pages = $sanPham->baiBao->pages ?? null;
        $a->trangthairasoat = $sanPham->trangthairasoat;
        $a->deleted_at = $sanPham->deleted_at ?? null;
        $a->created_at = $sanPham->created_at;
        $a->updated_at = $sanPham->updated_at;

        return $a;
    }

    public static function getBaiBaoKhoaHocDetailVm(SanPham $sanPham)
    {
        $a = new BaiBaoKhoaHocDetailVm();
        $a->id = $sanPham->baiBao->id;

        $a->sanpham = Convert::getSanPhamDetailVm($sanPham);

        $a->doi = $sanPham->baiBao->doi ?? null;
        $a->url = $sanPham->baiBao->url ?? null;
        $a->received = $sanPham->baiBao->received ?? null;
        $a->accepted = $sanPham->baiBao->accepted ?? null;
        $a->published = $sanPham->baiBao->published ?? null;
        $a->abstract = $sanPham->baiBao->abstract ?? null;
        $a->keywords = $sanPham->baiBao->keywords ?? null;
        if ($sanPham->baiBao->tapChi == null) {
            $a->tapchi = null;
        } else {
            $a->tapchi = Convert::getTapChiVm($sanPham->baiBao->tapChi);
        }
        $a->volume = $sanPham->baiBao->volume ?? null;
        $a->issue = $sanPham->baiBao->issue ?? null;
        $a->number = $sanPham->baiBao->number ?? null;
        $a->pages = $sanPham->baiBao->pages ?? null;
        $a->deleted_at = $sanPham->baiBao->sanPham->deleted_at ?? null;
        $a->created_at = $sanPham->baiBao->created_at;
        $a->updated_at = $sanPham->baiBao->updated_at;

        foreach ($sanPham->sanPhamsTacGias as $sanPhaMTacGia) {
            $a->sanpham_tacgias[] = Convert::getSanPhamTacGiaVm($sanPhaMTacGia);
        }
        return $a;
    }


    // ========================= DE TAI ============================= //

    public static function getDeTaiVm(SanPham $sanPham)
    {
        $a = new DeTaiVm();
        $a->id = $sanPham->deTai->id;
        $a->tensannpham = $sanPham->tensanpham ?? null;
        $a->id_sanpham = $sanPham->id;
        $a->maso = $sanPham->deTai->maso;
        $a->ngaydangky = $sanPham->deTai->ngaydangky ?? null;
        $a->capdetai = $sanPham->deTai->capdetai ?? null;
        $a->created_at = $sanPham->deTai->created_at;
        $a->updated_at = $sanPham->deTai->updated_at;
        return $a;
    }
    public static function getDeTaiDetailVm(SanPham $sanPham)
    {
        $a = new DeTaiDetailVm();
        $a->id = $sanPham->deTai->id;
        $a->trangthai = "Chờ tuyển chọn";
        if ($sanPham->tuyenChon()->exists() && $sanPham->tuyenChon->ketquatuyenchon == "Không đủ điều kiện") {
            $a->trangthai = "Tuyển chọn thât bại";
        }
        if ($sanPham->tuyenChon()->exists() && $sanPham->tuyenChon->ketquatuyenchon == "Đủ điều kiện") {
            $a->trangthai = "Chờ xét duyệt";
        }
        if ($sanPham->xetDuyet()->exists() && $sanPham->xetDuyet->ketquaxetduyet == "Không đủ điều kiện") {
            $a->trangthai = "Xét duyệt thất bại";
        }
        if ($sanPham->xetDuyet()->exists()  && $sanPham->xetDuyet->ketquaxetduyet == "Đủ điều kiện") {
            $a->trangthai = "Chờ nghiệm thu";
        }
        if ($sanPham->nghiemThu()->exists()) {
            $a->trangthai = "Nghiệm thu";
        }
        $a->sanpham = Convert::getSanPhamDetailVm($sanPham);
        $a->maso = $sanPham->deTai->maso;
        $a->ngaydangky = $sanPham->deTai->ngaydangky ?? null;
        $a->ngoaitruong = $sanPham->deTai->ngoaitruong ?? null;
        $a->truongchutri = $sanPham->deTai->truongchutri ?? null;
        $a->tochucchuquan = $sanPham->deTai->toChucChuQuan == null ? null : Convert::getToChucVm($sanPham->deTai->toChucChuQuan); // $id_tochuchuquan -- tochuc
        $a->loaidetai = $sanPham->deTai->phanLoaiDeTai == null ? null : Convert::getPhanLoaiDeTaiVm($sanPham->deTai->phanLoaiDeTai); // $id_loaidetai -- phanloaidetai
        $a->detaihoptac = $sanPham->deTai->detaihoptac ?? null;
        $a->tochuchoptac = $sanPham->deTai->toChucHopTac == null ? null : Convert::getToChucVm($sanPham->deTai->toChucHopTac); // $id_tochuchoptac -- tochuc
        $a->tylekinhphidonvihoptac = $sanPham->deTai->tylekinhphidonvihoptac ?? null;
        $a->capdetai = $sanPham->deTai->capdetai ?? null;
        $a->created_at = $sanPham->deTai->created_at;
        $a->updated_at = $sanPham->deTai->updated_at;
        return $a;
    }
    public static function getBaoCaoTienDoVm(BaoCaoTienDo $baoCaoTienDo)
    {
        $a = new BaoCaoTienDoVm();
        $a->id = $baoCaoTienDo->id;
        $a->ngaynopbaocao = $baoCaoTienDo->ngaynopbaocao ?? null;
        $a->ketquaxet = $baoCaoTienDo->ketquaxet ?? null;
        $a->thoigiangiahan = $baoCaoTienDo->thoigiangiahan ?? null;
        $a->created_at = $baoCaoTienDo->created_at;
        $a->updated_at = $baoCaoTienDo->updated_at;
        return $a;
    }
    public static function getNghiemThuVm(NghiemThu $nghiemThu)
    {
        $a = new NghiemThuVm();
        $a->id = $nghiemThu->id;
        $a->hoidongnghiemthu = $nghiemThu->hoidongnghiemthu ?? null;
        $a->ngaynghiemthu = $nghiemThu->ngaynghiemhtu ?? null;
        $a->ketquanghiemthu = $nghiemThu->ketquanghiemthu ?? null;
        $a->ngaycongnhanhoanthanh = $nghiemThu->ngaycongnhanhoanthanh ?? null;
        $a->soqdcongnhanhoanthanh = $nghiemThu->soqdcongnhanhoanthanh ?? null;
        $a->thoigianhoanthanh = $nghiemThu->thoigianhoanthanh ?? null;
        $a->created_at = $nghiemThu->created_at;
        $a->updated_at = $nghiemThu->updated_at;
        return $a;
    }
    public static function getPhanLoaiDeTaiVm(PhanLoaiDeTai $phanLoaiDeTai)
    {
        $a = new PhanLoaiDeTaiVm();
        $a->id = $phanLoaiDeTai->id;
        $a->maloai = $phanLoaiDeTai->maloai ?? null;
        $a->tenloai = $phanLoaiDeTai->tenloai;
        $a->kinhphi = $phanLoaiDeTai->kinhphi ?? null;
        $a->mota = $phanLoaiDeTai->mota ?? null;
        $a->created_at = $phanLoaiDeTai->created_at;
        $a->updated_at = $phanLoaiDeTai->updated_at;
        return $a;
    }
    public static function getXetDuyetVm(XetDuyet $xetDuyet)
    {
        $a = new XetDuyetVm();
        $a->id = $xetDuyet->id;
        $a->ngayxetduyet = $xetDuyet->ngayxetduyet ?? null;
        $a->ketquaxetduyet = $xetDuyet->ketquaxetduyet ?? null;
        $a->sohopdong = $xetDuyet->sohopdong ?? null;
        $a->ngaykyhopdong = $xetDuyet->ngaykyhopdong ?? null;
        $a->thoihanhopdong = $xetDuyet->thoihanhopdong ?? null;
        $a->kinhphi = $xetDuyet->kinhphi ?? null;
        $a->created_at = $xetDuyet->created_at;
        $a->updated_at = $xetDuyet->updated_at;
        return $a;
    }

    public static function getTuyenChonVm(TuyenChon $tuyenChon)
    {
        $a = new TuyenChonVm();
        $a->id = $tuyenChon->id;
        $a->ketquatuyenchon = $tuyenChon->ketquatuyenchon;
        $a->lydo = $tuyenChon->lydo ?? null;
        $a->created_at = $tuyenChon->created_at;
        $a->updated_at = $tuyenChon->updated_at;

        return $a;
    }




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
