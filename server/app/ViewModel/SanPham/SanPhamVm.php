<?php

namespace App\ViewModel\SanPham;

use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\ToChucVm;

class SanPhamVm
{
    private $id;
    private $tensanpham;
    private $loaiSanPhamVm; // $id_loaisanpham -- DMSanPhamVm
    private $tongsotacgia;
    private $solanquydoi;
    private $cosudungemailtruong;
    private $cosudungemaildonvikhac;
    private $cothongtintruong;
    private $cothongtindonvikhac;
    private $thongTinNoiKhacVm; // $id_thongtinnoikhac -- ToChucVm
    private $conhantaitro;
    private $donViTaiTroVm; // $id_donvitaitro -- ToChucVm
    private $chitietdonvitaitro;
    private $ngaykekhai;
    private $nguoiKeKhaiVm; // $id_nguoikekhai -- UserVm
    private $trangthairasoat;
    private $ngayrasoat;
    private $nguoiRaSoatVm; // $id_nguoirasoat -- UserVm
    private $diemquydoi;
    private $gioquydoi;
    private $thongtinchitiet;
    private $capsanpham;
    private $thoidiemcongbohoanthanh;
    private $created_at;
    private $updated_at;

    function __construct()
    {
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getTenSanPham()
    {
        return $this->tensanpham;
    }

    function setTenSanPham($tensanpham)
    {
        $this->tensanpham = $tensanpham;
    }

    function getLoaiSanPhamVm()
    {
        return $this->loaiSanPhamVm;
    }

    function setLoaiSanPhamVm(DMSanPhamVm $loaiSanPhamVm)
    {
        $this->loaiSanPhamVm = $loaiSanPhamVm;
    }

    function getTongSoTacGia()
    {
        return $this->tongsotacgia;
    }

    function setTongSoTacGia($tongsotacgia)
    {
        $this->tongsotacgia = $tongsotacgia;
    }

    function getSoLanQuyDoi()
    {
        return $this->solanquydoi;
    }

    function setSoLanQuyDoi($solanquydoi)
    {
        $this->solanquydoi = $solanquydoi;
    }

    function getCoSuDungEmailTruong()
    {
        return $this->cosudungemailtruong;
    }

    function setCoSuDungEmailTruong($cosudungemailtruong)
    {
        $this->cosudungemailtruong = $cosudungemailtruong;
    }

    function getCoSuDungEmailDonViKhac()
    {
        return $this->cosudungemaildonvikhac;
    }

    function setCoSuDungEmailDonViKhac($cosudungemaildonvikhac)
    {
        $this->cosudungemaildonvikhac = $cosudungemaildonvikhac;
    }

    function getCoThongTinTruong()
    {
        return $this->cothongtintruong;
    }

    function setCoThongTinTruong($cothongtintruong)
    {
        $this->cothongtintruong = $cothongtintruong;
    }

    function getCoThongTinDonViKhac()
    {
        return $this->cothongtindonvikhac;
    }

    function setCoThongTinDonViKhac($cothongtindonvikhac)
    {
        $this->cothongtindonvikhac = $cothongtindonvikhac;
    }

    function getThongTinNoiKhacVm()
    {
        return $this->thongTinNoiKhacVm;
    }

    function setThongTinNoiKhacVm(ToChucVm $thongTinNoiKhacVm)
    {
        $this->thongTinNoiKhacVm = $thongTinNoiKhacVm;
    }

    function getCoNhanTaiTro()
    {
        return $this->conhantaitro;
    }

    function setCoNhanTaiTro($conhantaitro)
    {
        $this->conhantaitro = $conhantaitro;
    }

    function getDonViTaiTroVm()
    {
        return $this->donViTaiTroVm;
    }

    function setDonViTaiTroVm(ToChucVm $donViTaiTroVm)
    {
        $this->donViTaiTroVm = $donViTaiTroVm;
    }

    function getChiTietDonViTaiTro()
    {
        return $this->chitietdonvitaitro;
    }

    function setChiTietDonViTaiTro($chitietdonvitaitro)
    {
        $this->chitietdonvitaitro = $chitietdonvitaitro;
    }

    function getNgayKeKhai()
    {
        return $this->ngaykekhai;
    }

    function setNgayKeKhai($ngaykekhai)
    {
        $this->ngaykekhai = $ngaykekhai;
    }

    function getNguoiKeKhaiVm()
    {
        return $this->nguoiKeKhaiVm;
    }

    function setNguoiKeKhaiVm(UserVm $nguoiKeKhaiVm)
    {
        $this->nguoiKeKhaiVm = $nguoiKeKhaiVm;
    }

    function getTrangThaiRaSoat()
    {
        return $this->trangthairasoat;
    }

    function setTrangThaiRaSoat($trangthairasoat)
    {
        $this->trangthairasoat = $trangthairasoat;
    }

    function getNgayRaSoat()
    {
        return $this->ngayrasoat;
    }

    function setNgayRaSoat($ngayrasoat)
    {
        $this->ngayrasoat = $ngayrasoat;
    }

    function getNguoiRaSoatVm()
    {
        return $this->nguoiRaSoatVm;
    }

    function setNguoiRaSoatVm(UserVm $nguoiRaSoatVm)
    {
        $this->nguoiRaSoatVm = $nguoiRaSoatVm;
    }

    function getDiemQuyDoi()
    {
        return $this->diemquydoi;
    }

    function setDiemQuyDoi($diemquydoi)
    {
        $this->diemquydoi = $diemquydoi;
    }

    function getGioQuyDoi()
    {
        return $this->gioquydoi;
    }

    function setGioQuyDoi($gioquydoi)
    {
        $this->gioquydoi = $gioquydoi;
    }

    function getThongTinChiTiet()
    {
        return $this->thongtinchitiet;
    }

    function setThongTinChiTiet($thongtinchitiet)
    {
        $this->thongtinchitiet = $thongtinchitiet;
    }

    function getCapSanPham()
    {
        return $this->capsanpham;
    }

    function setCapSanPham($capsanpham)
    {
        $this->capsanpham = $capsanpham;
    }

    function getThoiDiemCongBoHoanThanh()
    {
        return $this->thoidiemcongbohoanthanh;
    }

    function setThoiDiemCongBoHoanThanh($thoidiemcongbohoanthanh)
    {
        $this->thoidiemcongbohoanthanh = $thoidiemcongbohoanthanh;
    }

    function getCreatedAt()
    {
        return $this->created_at;
    }

    function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    function getUpdatedAt()
    {
        return $this->updated_at;
    }

    function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }
}
