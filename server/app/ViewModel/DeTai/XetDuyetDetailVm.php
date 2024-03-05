<?php

use App\Models\DeTai\XetDuyet;
use App\ViewModel\SanPham\SanPhamVm;

class XetDuyetDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public string $ngayxetduyet;
    public string $sohopdong;
    public string $ngaykyhopdong;
    public string $thoihanhopdong;
    public string $kinhphi;
    public string $created_at;
    public string $updated_at;

    private $sanPhamVm;

    function __construct()
    {
        $this->sanPhamVm = new SanPhamVm();
    }

    public function convert(XetDuyet $xetDuyet)
    {
        $this->id = $xetDuyet->id;
        $this->sanpham = $this->sanPhamVm->convert($xetDuyet->sanPham);
        $this->ngayxetduyet = $xetDuyet->ngayxetduyet;
        $this->sohopdong = $xetDuyet->sohopdong;
        $this->ngaykyhopdong = $xetDuyet->ngaykyhopdong;
        $this->thoihanhopdong = $xetDuyet->thoihanhopdong;
        $this->kinhphi = $xetDuyet->kinhphi;
        $this->created_at = $xetDuyet->created_at;
        $this->updated_at = $xetDuyet->updated_at;
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

    function getNgayXetDuyet()
    {
        return $this->ngayxetduyet;
    }

    function setNgayXetDuyet($ngayxetduyet)
    {
        $this->ngayxetduyet = $ngayxetduyet;
    }

    function getSoHopDong()
    {
        return $this->sohopdong;
    }

    function setSoHopDong($sohopdong)
    {
        $this->sohopdong = $sohopdong;
    }

    function getNgayKyHopDong()
    {
        return $this->ngaykyhopdong;
    }

    function setNgayKyHopDong($ngaykyhopdong)
    {
        $this->ngaykyhopdong = $ngaykyhopdong;
    }

    function getThoiHanHopDong()
    {
        return $this->thoihanhopdong;
    }

    function setThoiHanHopDong($thoihanhopdong)
    {
        $this->thoihanhopdong = $thoihanhopdong;
    }

    function getKinhPhi()
    {
        return $this->kinhphi;
    }

    function setKinhPhi($kinhphi)
    {
        $this->kinhphi = $kinhphi;
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
