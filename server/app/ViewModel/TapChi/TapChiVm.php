<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;

class TapChiVm
{
    private $id;
    private $name;
    private $issn;
    private $eissn;
    private $pissn;
    private $website;
    private $quocte;
    private $nhaXuatBanVm; // $id_nhaxuatban
    private $donViChuQuanVm; // $id_donvichuquan -- ToChucVm
    private $address;
    private $addressCityVm; // $id_address_city -- TinhThanhVM
    private $addressCountryVm; // id_address_country -- QuocGiaVm
    private $trangthai;
    private $nguoiThemVm; // $di_nguoithem -- UserVm
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

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
    }

    function getIssn()
    {
        return $this->issn;
    }

    function setIssn($issn)
    {
        $this->issn = $issn;
    }

    function getEissn()
    {
        return $this->eissn;
    }

    function setEissn($eissn)
    {
        $this->eissn = $eissn;
    }

    function getPissn()
    {
        return $this->pissn;
    }

    function setPissn($pissn)
    {
        $this->pissn = $pissn;
    }

    function getWebsite()
    {
        return $this->website;
    }

    function setWebsite($website)
    {
        $this->website = $website;
    }

    function getQuocTe()
    {
        return $this->quocte;
    }

    function setQuocTe($quocte)
    {
        $this->quocte = $quocte;
    }

    function getNhaXuatBanVm()
    {
        return $this->nhaXuatBanVm;
    }

    function setNhaXuatBanVm(NhaXuatBanVm $nhaXuatBanVm)
    {
        $this->nhaXuatBanVm = $nhaXuatBanVm;
    }

    function getDonViChuQuan()
    {
        return $this->donViChuQuanVm;
    }

    function setDonViChuQuanVm(ToChucVm $donViChuQuanVm)
    {
        $this->donViChuQuanVm = $donViChuQuanVm;
    }

    function getAddress()
    {
        return $this->address;
    }

    function setAddress($address)
    {
        $this->address = $address;
    }

    function getAddressCityVm()
    {
        return $this->addressCityVm;
    }

    function setAddressCityVm(TinhThanhVm $addressCityVm)
    {
        $this->addressCityVm = $addressCityVm;
    }

    function getAddressCountryVm()
    {
        return $this->addressCountryVm;
    }

    function setAddressCountryVm(QuocGiaVm $addressCountryVm)
    {
        $this->addressCountryVm = $addressCountryVm;
    }

    function getTrangThai()
    {
        return $this->trangthai;
    }

    function setTrangThai($trangthai)
    {
        $this->trangthai = $trangthai;
    }

    function getNguoiThemVm()
    {
        return $this->nguoiThemVm;
    }

    function setNguoiThemVm(UserVm $nguoiThemVm)
    {
        $this->nguoiThemVm = $nguoiThemVm;
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
