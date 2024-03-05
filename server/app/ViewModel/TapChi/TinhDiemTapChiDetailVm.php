<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\Models\TapChi\TinhDiemTapChi;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\User\UserVm;

class TinhDiemTapChiDetailVm
{
    public int $id;
    public TapChiVm $tapchi; // $id_tapchi
    public NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public ChuyenNganhTinhDiemVm $chuyennganhtinhdiem; // $id_chuyennganhtinhdiem
    public ?string $diem;
    public ?string $namtinhdiem;
    public ?UserVm $nguoicapnhat; // $id_nguoicapnhat -- UserVm
    public ?string $ghichu;
    public string $created_at;
    public string $updated_at;


    private $tapChiVm;
    private $nganhTinhDiemVm;
    private $chuyenNganhTinhDiemVm;
    private $userVm;

    public function __construct()
    {
        $this->tapChiVm = new TapChiVm();
        $this->nganhTinhDiemVm = new NganhTinhDiemVm();
        $this->chuyenNganhTinhDiemVm = new ChuyenNganhTinhDiemVm();
        $this->userVm = new UserVm();
    }

    public function convert(TinhDiemTapChi $tinhDiemTapChi)
    {
        $this->id = $tinhDiemTapChi->id;
        $this->tapchi = $this->tapChiVm->convert($tinhDiemTapChi->tapChi);
        $this->nganhtinhdiem = $this->nganhTinhDiemVm->convert($tinhDiemTapChi->nganhTinhDiem);
        $this->chuyennganhtinhdiem = $this->chuyenNganhTinhDiemVm->convert($tinhDiemTapChi->chuyenNganhTinhDiem);
        $this->diem = $tinhDiemTapChi->diem;
        $this->namtinhdiem = $tinhDiemTapChi->namtinhdiem;
        $this->nguoicapnhat = $this->userVm->convert($tinhDiemTapChi->nguoiCapNhat);
        $this->ghichu = $tinhDiemTapChi->ghichu;
        $this->created_at = $tinhDiemTapChi->created_at;
        $this->updated_at = $tinhDiemTapChi->updated_at;
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

    function getNganhTinhDiem()
    {
        return $this->nganhtinhdiem;
    }

    function setNganhTinhDiemVm(NganhTinhDiemVm $nganhTinhDiemVm)
    {
        $this->nganhtinhdiem = $nganhTinhDiemVm;
    }

    function getChuyenNganhTinhDiem()
    {
        return $this->chuyennganhtinhdiem;
    }

    function setChuyenNganhTinhDiem(ChuyenNganhTinhDiemVm $chuyenNganhTinhDiemVm)
    {
        $this->chuyennganhtinhdiem = $chuyenNganhTinhDiemVm;
    }

    function getDiem()
    {
        return $this->diem;
    }

    function setDiem($diem)
    {
        $this->diem = $diem;
    }

    function getNamTinhDiem()
    {
        return $this->namtinhdiem;
    }

    function setNamTinhDiem($namtinhdiem)
    {
        $this->namtinhdiem = $namtinhdiem;
    }

    function getNguoiCapNhat()
    {
        return $this->nguoicapnhat;
    }

    function setNguoiCapNhat(UserVm $nguoiCapNhatVm)
    {
        $this->nguoicapnhat = $nguoiCapNhatVm;
    }

    function getGhiChu()
    {
        return $this->ghichu;
    }

    function setGhiChu($ghichu)
    {
        $this->ghichu = $ghichu;
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
