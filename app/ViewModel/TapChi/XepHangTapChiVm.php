<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\User\UserVm;

class XepHangTapChiVm
{
    private $id;
    private $tapChiVm; // $id_tapchi
    private $wos;
    private $if;
    private $quartile;
    private $abs;
    private $abcd;
    private $aci;
    private $ghichu;
    private $userVm; // $id_user
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

    function getgetTapChiVm()
    {
        return $this->tapChiVm;
    }

    function setTapChiVm(TapChiVm $tapChiVm)
    {
        $this->tapChiVm = $tapChiVm;
    }

    function getWos()
    {
        return $this->wos;
    }

    function setWos($wos)
    {
        $this->wos = $wos;
    }

    function getIf()
    {
        return $this->if;
    }

    function setIf($if)
    {
        $this->if = $if;
    }

    function getQuartile()
    {
        return $this->quartile;
    }

    function setQuartile($quartile)
    {
        $this->quartile = $quartile;
    }

    function getAbc()
    {
        return $this->abs;
    }

    function setAbc($abs)
    {
        $this->abs = $abs;
    }

    function getAbcd()
    {
        return $this->abcd;
    }

    function setAbcd($abcd)
    {
        $this->abcd = $abcd;
    }

    function getAci()
    {
        return $this->aci;
    }

    function setAci($aci)
    {
        $this->aci = $aci;
    }

    function getGhiChu()
    {
        return $this->ghichu;
    }

    function setGhiChu($ghichu)
    {
        $this->ghichu = $ghichu;
    }

    function getUserVm()
    {
        return $this->userVm;
    }

    function setUserVm(UserVm $userVm)
    {
        $this->userVm = $userVm;
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
