<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\User\UserVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class TapChiKhongCongNhanVm
{
    public Integer $id;
    public TapChiVm $tapchi; // $id_tapchi
    public Boolean $khongduoccongnhan;
    public string $ghichu;
    public UserVm $nguoicapnhat; // $id_nguoicapnhap -- UserVm 
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

    function getTapChi()
    {
        return $this->tapchi;
    }

    function setTapChi(TapChiVm $tapChiVm)
    {
        $this->tapchi = $tapChiVm;
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

    function getNguoiCapNhat()
    {
        return $this->nguoicapnhat;
    }

    function setNguoiCapNhat(UserVm $nguoiCapNhatVm)
    {
        $this->nguoicapnhat = $nguoiCapNhatVm;
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
