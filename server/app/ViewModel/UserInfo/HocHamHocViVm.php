<?php

namespace App\ViewModel\UserInfo;

class HocHamHocViVm
{
    private $id;
    private $mahochamhocvi;
    private $tenhochamhocvi;
    private $tenhochamhocvi_en;
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
