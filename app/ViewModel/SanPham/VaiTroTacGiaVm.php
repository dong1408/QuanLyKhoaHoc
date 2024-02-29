<?php

namespace App\ViewModel\SanPham;

class VaiTroTacGiaVm
{
    private $id;
    private $tenvaitro;
    private $tenvaitro_en;
    private $mota;
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

    function getTenVaiTro()
    {
        return $this->tenvaitro;
    }

    function setTenVaiTro($tenvaitro)
    {
        $this->tenvaitro = $tenvaitro;
    }

    function getTenVaiTro_en()
    {
        return $this->tenvaitro_en;
    }

    function setTenVaiTro_en($tenvaitro_en)
    {
        $this->tenvaitro_en = $tenvaitro_en;
    }

    function getMoTa()
    {
        return $this->mota;
    }

    function setMoTa($mota)
    {
        $this->mota = $mota;
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
