<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\User\UserVm;
use Ramsey\Uuid\Type\Integer;

class XepHangTapChiVm
{
    public Integer $id;
    public TapChiVm $tapchi; // $id_tapchi
    public string $wos;
    public string $if;
    public string $quartile;
    public string $abs;
    public string $abcd;
    public string $aci;
    public string $ghichu;
    public UserVm $user; // $id_user
    public string $created_at;
    public string $updated_at;

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

    function getgetTapChi()
    {
        return $this->tapchi;
    }

    function setTapChi(TapChiVm $tapChiVm)
    {
        $this->tapchi = $tapChiVm;
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

    function getUser()
    {
        return $this->user;
    }

    function setUser(UserVm $userVm)
    {
        $this->user = $userVm;
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
