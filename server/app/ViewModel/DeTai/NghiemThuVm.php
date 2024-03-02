<?php

use App\ViewModel\SanPham\SanPhamVm;

class NghiemThuVm
{
    public $id;
    public SanPhamVm $sanpham; // $id_sanpham;
    public string $hoidongnghiemthu;
    public string $ngaynghiemthu;
    public string $ketquanghiemthu;
    public string $ngaycongnhanhoanthanh;
    public string $soqdcongnhanhoanthanh;
    public string $thoigianhoanthanh;
    public string $created_at;
    public string $updated_at;

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

    function getSanPham()
    {
        return $this->sanpham;
    }

    function setSanPham(SanPhamVm $sanPhamVm)
    {
        $this->sanpham = $sanPhamVm;
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
