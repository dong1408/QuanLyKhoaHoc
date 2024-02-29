<?php

namespace App\ViewModel\UserInfo;

class ChuyenMonVm
{
    private $id;
    private $machuyenmon;
    private $tenchuyenmon;
    private $tenchuyenmon_en;
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

    function getMaChuyenMon()
    {
        return $this->machuyenmon;
    }

    function setMaChuyenMon($machuyenmon)
    {
        $this->machuyenmon = $machuyenmon;
    }

    function getTenChuyenMon()
    {
        return $this->tenchuyenmon;
    }

    function setTenChuyenMon($tenchuyenmon)
    {
        $this->tenchuyenmon = $tenchuyenmon;
    }

    function getTenChuyenMon_en()
    {
        return $this->tenchuyenmon_en;
    }

    function setTenChuyenMon_en($tenchuyenmon_en)
    {
        $this->tenchuyenmon_en = $tenchuyenmon_en;
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
