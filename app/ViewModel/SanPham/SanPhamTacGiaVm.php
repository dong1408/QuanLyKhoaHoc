<?php

namespace App\ViewModel\SanPham;

use App\ViewModel\User\UserVm;

class SanPhamTacGiaVm
{
    private $id;
    private $sanPhamVm; //$id_sanpham
    private $tacGiaVm; // $id_tacgia -- user
    private $vaiTroTacGiaVm; //$id_vaotrotacgia 
    private $thutu;
    private $tyledonggop;
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

    function getTacGiaVm()
    {
        return $this->tacGiaVm;
    }

    function setTacGiaVm(UserVm $tacGiaVm)
    {
        $this->tacGiaVm = $tacGiaVm;
    }

    function getVaiTroTacGiaVm()
    {
        return $this->vaiTroTacGiaVm;
    }

    function setVaiTroTacGiaVm(VaiTroTacGiaVm $vaiTroTacGiaVm)
    {
        $this->vaiTroTacGiaVm = $vaiTroTacGiaVm;
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
