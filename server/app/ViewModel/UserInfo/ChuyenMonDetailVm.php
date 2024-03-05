<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMChuyenMon;

class ChuyenMonDetailVm
{
    public int $id;
    public string $machuyenmon;
    public string $tenchuyenmon;
    public string $tenchuyenmon_en;
    public string $created_at;
    public string $updated_at;

    public function __construct()
    {
    }

    public function convert(DMChuyenMon $dMChuyenMon){
        $this->id = $dMChuyenMon->id;
        $this->machuyenmon = $dMChuyenMon->machuyenmon;
        $this->tenchuyenmon = $dMChuyenMon->tenchuyenmon;
        $this->tenchuyenmon_en = $dMChuyenMon->tenchuyenmon_en;
        $this->created_at = $dMChuyenMon->created_at;
        $this->updated_at = $dMChuyenMon->updated_at;
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
