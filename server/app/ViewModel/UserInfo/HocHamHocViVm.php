<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMHocHamHocVi;
use Ramsey\Uuid\Type\Integer;

class HocHamHocViVm
{
    public int $id;
    public string $mahochamhocvi;
    public string $tenhochamhocvi;
    public string $tenhochamhocvi_en;
    public string $created_at;
    public string $updated_at;

    public function __construct()
    {
    }

    public function convert(DMHocHamHocVi $dMHocHamHocVi)
    {
        $this->id = $dMHocHamHocVi->id;
        $this->mahochamhocvi = $dMHocHamHocVi->mahochamhocvi;
        $this->tenhochamhocvi = $dMHocHamHocVi->tenhochamhocvi;
        $this->tenhochamhocvi_en = $dMHocHamHocVi->tenhochamhocvi_en;
        $this->created_at = $dMHocHamHocVi->created_at;
        $this->updated_at = $dMHocHamHocVi->updated_at;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    function getMaHocHamHocVi()
    {
        return $this->mahochamhocvi;
    }

    function setMaHocHamHocVi($mahochamhocvi)
    {
        $this->mahochamhocvi = $mahochamhocvi;
    }

    function getTenHocHamHocVi()
    {
        return $this->tenhochamhocvi;
    }

    function setTenHocHamHocVi($tenhochamhocvi)
    {
        $this->tenhochamhocvi = $tenhochamhocvi;
    }

    function getTenHocHamHocVi_en()
    {
        return $this->tenhochamhocvi_en;
    }

    function setTenHocHamHocVi_en($tenhochamhocvi_en)
    {
        $this->tenhochamhocvi_en = $tenhochamhocvi_en;
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
