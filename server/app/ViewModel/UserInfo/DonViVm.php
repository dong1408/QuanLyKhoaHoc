<?php

namespace App\ViewModel\UserInfo;

class DonViVm
{
    private $id;
    private $toChucVm; // $id_tochuc
    private $madonvi;
    private $tendonvi;
    private $tendonvi_en;
    private $created_at;
    private $updated_at;

    public function __construct()
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

    function getToChucVm()
    {
        return $this->toChucVm;
    }

    function setToChucVm(ToChucVm $toChucVm)
    {
        $this->toChucVm = $toChucVm;
    }

    function getMaDonVi()
    {
        return $this->madonvi;
    }

    function setMaDonVi($madonvi)
    {
        $this->madonvi = $madonvi;
    }

    function getTenDonVi()
    {
        return $this->tendonvi;
    }

    function setTenDonVi($tendonvi)
    {
        $this->tendonvi = $tendonvi;
    }

    function getTenDonVi_en()
    {
        return $this->tendonvi_en;
    }

    function setTenDonVi_en($tendonvi_en)
    {
        $this->tendonvi_en = $tendonvi_en;
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
