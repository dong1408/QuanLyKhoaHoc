<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChiKhongCongNhan;
use App\ViewModel\User\UserVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class TapChiKhongCongNhanVm
{
    public int $id;
    public TapChiVm $tapchi; // $id_tapchi
    public ?bool $khongduoccongnhan;
    public ?string $ghichu;
    public ?UserVm $nguoicapnhat; // $id_nguoicapnhap -- UserVm 
    public string $created_at;
    public string $updated_at;


    private UserVm $userVm;

    public function __construct()
    {
    }

    public function getTapChiKhongCongNhanVm(TapChiKhongCongNhan $tapChiKhongCongNhan):TapChiKhongCongNhanVm{
        $a = new TapChiKhongCongNhanVm();
        $a->id = $tapChiKhongCongNhan->id;

        return $a;
    }

    public function convert(TapChiKhongCongNhan $tapChiKhongCongNhan)
    {
        $this->id = $tapChiKhongCongNhan->id;
        // $this->tapchi = $this->tapChiVm->convert($tapChiKhongCongNhan->tapChi);
        $this->khongduoccongnhan = $tapChiKhongCongNhan->khongduoccongnhan;
        // $this->ghichu = $tapChiKhongCongNhan->ghichu;
        // $this->nguoicapnhat = $this->userVm->convert($tapChiKhongCongNhan->nguoiCapNhat);
        // $this->created_at = $tapChiKhongCongNhan->created_at;
        // $this->updated_at = $tapChiKhongCongNhan->updated_at;
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
