<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\User\UserVm;

class TapChiKhongCongNhanVm
{
    private $id;
    private $tapChiVm; // $id_tapchi
    private $khongduoccongnhan;
    private $ghichu;
    private $nguoiCapNhatVm; // $id_nguoicapnhap -- UserVm 
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

    function getTapChiVm()
    {
        return $this->tapChiVm;
    }

    function setTapChiVm($tapChiVm)
    {
        $this->tapChiVm = $tapChiVm;
    }

    function getKhongDuocCongNhan()
    {
        return $this->khongduoccongnhan;
    }

    function setKhongDuocCongNhan($khongduoccongnhan)
    {
        $this->khongduoccongnhan = $khongduoccongnhan;
    }

    function getGhiChu()
    {
        return $this->ghichu;
    }

    function setGhiChu($ghichu)
    {
        $this->ghichu = $ghichu;
    }

    function getNguoiCapNhatVm()
    {
        return $this->nguoiCapNhatVm;
    }

    function setNguoiCapNhatVm(UserVm $nguoiCapNhatVm)
    {
        $this->nguoiCapNhatVm = $nguoiCapNhatVm;
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
