<?php

namespace App\ViewModel\UserInfo;

class ToChucVm
{
    private $id;
    private $matochuc;
    private $tentochuc;
    private $tentochuc_en;
    private $website;
    private $dienthoai;
    private $address;
    private $addressCityVm; // $id_address_city -- TinhThanhVm
    private $addressCountryVm; // $id_address_country -- QuocGiaVm
    private $phanLoaiToChucVm; // $id_phanloaitochuc
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

    function getMaToChuc()
    {
        return $this->matochuc;
    }

    function setMaToChuc($matochuc)
    {
        $this->matochuc = $matochuc;
    }

    function getTenToChuc()
    {
        return $this->tentochuc;
    }

    function setTenToChuc($tentochuc)
    {
        $this->tentochuc = $tentochuc;
    }

    function getTenToChuc_en()
    {
        return $this->tentochuc_en;
    }

    function setTenToChuc_en($tentochuc_en)
    {
        $this->tentochuc_en = $tentochuc_en;
    }

    function getWebsite()
    {
        return $this->website;
    }

    function setWebsite($website)
    {
        $this->website = $website;
    }

    function getDienThoai()
    {
        return $this->dienthoai;
    }

    function setDienThoai($dienthoai)
    {
        $this->dienthoai = $dienthoai;
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

    function getPhanLoaiToChucVm()
    {
        return $this->phanLoaiToChucVm;
    }

    function setPhanLoaiToChucVm(PhanLoaiToChucVm $phanLoaiToChucVm)
    {
        $this->phanLoaiToChucVm = $phanLoaiToChucVm;
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
