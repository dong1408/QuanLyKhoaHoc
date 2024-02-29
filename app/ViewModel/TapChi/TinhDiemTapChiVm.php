<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\User\UserVm;

class TinhDiemTapChiVm
{
    private $id;
    private $tapChiVm; // $id_tapchi
    private $nganhTinhDiemVm; // $id_nganhtinhdiem
    private $chuyenNganhTinhDiemVm; // $id_chuyennganhtinhdiem
    private $diem;
    private $namtinhdiem;
    private $nguoiCapNhatVm; // $id_nguoicapnhat -- UserVm
    private $ghichu;
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

    function setTapChiVm(TapChiVm $tapChiVm)
    {
        $this->tapChiVm = $tapChiVm;
    }

    function getNganhTinhDiemVm()
    {
        return $this->nganhTinhDiemVm;
    }

    function setNganhTinhDiemVm(NganhTinhDiemVm $nganhTinhDiemVm)
    {
        $this->nganhTinhDiemVm = $nganhTinhDiemVm;
    }

    function getChuyenNganhTinhDiemVm()
    {
        return $this->chuyenNganhTinhDiemVm;
    }

    function setChuyenNganhTinhDiemVm(ChuyenNganhTinhDiemVm $chuyenNganhTinhDiemVm)
    {
        $this->chuyenNganhTinhDiemVm = $chuyenNganhTinhDiemVm;
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

    function getNguoiCapNhatVm()
    {
        return $this->nguoiCapNhatVm;
    }

    function setNguoiCapNhat(UserVm $nguoiCapNhatVm)
    {
        $this->nguoiCapNhatVm = $nguoiCapNhatVm;
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
