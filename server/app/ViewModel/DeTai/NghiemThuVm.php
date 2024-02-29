<?php

use App\ViewModel\SanPham\SanPhamVm;

class NghiemThuVm
{
    private $id;
    private $sanPhamVm; // $id_sanpham;
    private $hoidongnghiemthu;
    private $ngaynghiemthu;
    private $ketquanghiemthu;
    private $ngaycongnhanhoanthanh;
    private $soqdcongnhanhoanthanh;
    private $thoigianhoanthanh;
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

    function getSanPhamVm()
    {
        return $this->sanPhamVm;
    }

    function setSanPhamVm(SanPhamVm $sanPhamVm)
    {
        $this->sanPhamVm = $sanPhamVm;
    }

    function getHoiDongNghiemThu()
    {
        return $this->hoidongnghiemthu;
    }

    function setHoiDongNghiemThu($hoidongnghiemthu)
    {
        $this->hoidongnghiemthu = $hoidongnghiemthu;
    }

    function getNgayNghiemThu()
    {
        return $this->ngaynghiemthu;
    }

    function setNgayNghiemThu($ngaynghiemthu)
    {
        $this->ngaynghiemthu = $ngaynghiemthu;
    }

    function getKetQuaNghiemThu()
    {
        return $this->ketquanghiemthu;
    }

    function setKetQuaNghiemThu($ketquanghiemthu)
    {
        $this->ketquanghiemthu = $ketquanghiemthu;
    }

    function getNgayCongNhanHoanThanh()
    {
        return $this->ngaycongnhanhoanthanh;
    }

    function setNgayCongNhanHoanThanh($ngaycongnhanhoanthanh)
    {
        $this->ngaycongnhanhoanthanh = $ngaycongnhanhoanthanh;
    }

    function getSoQdCongNhanHoanThanh()
    {
        return $this->soqdcongnhanhoanthanh;
    }

    function setSoQdCongNhanHoanThanh($soqdcongnhanhoanthanh)
    {
        $this->soqdcongnhanhoanthanh = $soqdcongnhanhoanthanh;
    }

    function getThoiGianHoanThanh()
    {
        return $this->thoigianhoanthanh;
    }

    function setThoiGianHoanThanh($thoigianhoanthanh)
    {
        $this->thoigianhoanthanh = $thoigianhoanthanh;
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
