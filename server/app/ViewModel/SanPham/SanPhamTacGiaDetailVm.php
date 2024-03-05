<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\SanPhamTacGia;
use App\ViewModel\User\UserVm;
use Ramsey\Uuid\Type\Integer;

class SanPhamTacGiaDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; //$id_sanpham
    public UserVm $tacgia; // $id_tacgia -- user
    public VaiTroTacGiaVm $vaitrotacgia; //$id_vaotrotacgia 
    public string $thutu;
    public string $tyledonggop;
    public string $created_at;
    public string $updated_at;

    private $sanPhamVm;
    private $userVm;
    private $vaiTroTacGiaVm;

    function __construct()
    {
        $this->sanPhamVm = new SanPhamVm();
        $this->userVm = new UserVm();
        $this->vaiTroTacGiaVm = new VaiTroTacGiaVm();
    }

    public function convert(SanPhamTacGia $sanPhamTacGia)
    {
        $this->id = $sanPhamTacGia->id;
        $this->sanpham = $this->sanPhamVm->convert($sanPhamTacGia->sanPham);
        $this->tacgia = $this->userVm->convert($sanPhamTacGia->tacGia);
        $this->vaitrotacgia = $this->vaiTroTacGiaVm->convert($sanPhamTacGia->vaiTroTacGia);
        $this->thutu = $sanPhamTacGia->thutu;
        $this->tyledonggop = $sanPhamTacGia->tyledonggop;
        $this->created_at = $sanPhamTacGia->created_at;
        $this->updated_at = $sanPhamTacGia->updated_at;
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

    function getTacGia()
    {
        return $this->tacgia;
    }

    function setTacGia(UserVm $tacGiaVm)
    {
        $this->tacgia = $tacGiaVm;
    }

    function getVaiTroTacGia()
    {
        return $this->vaitrotacgia;
    }

    function setVaiTroTacGia(VaiTroTacGiaVm $vaiTroTacGiaVm)
    {
        $this->vaitrotacgia = $vaiTroTacGiaVm;
    }

    function getThuTu()
    {
        return $this->thutu;
    }

    function setThuTu($thutu)
    {
        $this->thutu = $thutu;
    }

    function getTyLeDongGop()
    {
        return $this->tyledonggop;
    }

    function setTyLeDongGop($tyledonggop)
    {
        $this->tyledonggop = $tyledonggop;
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
