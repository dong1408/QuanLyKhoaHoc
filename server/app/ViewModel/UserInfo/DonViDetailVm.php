<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMDonVi;
use Ramsey\Uuid\Type\Integer;

class DonViDetailVm
{
    public int $id;
    public ToChucVm $tochuc; // $id_tochuc
    public string $madonvi;
    public string $tendonvi;
    public string $tendonvi_en;
    public string $created_at;
    public string $updated_at;

    private $toChucVm;

    public function __construct()
    {
        $this->toChucVm = new ToChucVm();
    }

    public function convert(DMDonVi $dMDonVi){
        $this->id = $dMDonVi->id;
        $this->tochuc = $this->toChucVm->convert($dMDonVi->toChuc);
        $this->madonvi = $dMDonVi->madonvi;
        $this->tendonvi = $dMDonVi->tendonvi;
        $this->tendonvi_en = $dMDonVi->tendonvi_en;
        $this->created_at = $dMDonVi->created_at;
        $this->updated_at = $dMDonVi->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getToChuc()
    {
        return $this->tochuc;
    }

    function setToChuc(ToChucVm $toChucVm)
    {
        $this->tochuc = $toChucVm;
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
