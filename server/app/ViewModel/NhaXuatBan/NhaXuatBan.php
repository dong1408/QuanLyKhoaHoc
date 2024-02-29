<?php

namespace App\ViewModel\NhaXuatBan;

use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;

class NhaXuatBanVm
{
    private $id;
    private $isbn;
    private $website;
    private $quocte;
    private $address;
    private $addressCityVm; // $id_address_city -- TinhThanhVm
    private $addressCountryVm; // $id_address_country -- QuocGiaVm
    private $donViChuQuanVm; // $id_donvichuquan -- ToChucVm
    private $trangthai;
    private $nguoiThemVm; // $id_nguoithem -- UserVm
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

    function getIsbn()
    {
        return $this->isbn;
    }

    function setIsbn($isbn)
    {
        $this->isbn = $isbn;
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

    function getDonViChuQuanVm()
    {
        return $this->donViChuQuanVm;
    }

    function setDonViChuQuanVm(ToChucVm $donViChuQuanVm)
    {
        $this->donViChuQuanVm = $donViChuQuanVm;
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
