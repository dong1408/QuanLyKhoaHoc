<?php

namespace App\ViewModel\UserInfo;

use Ramsey\Uuid\Type\Integer;

class ToChucVm
{
    public Integer $id;
    public string $matochuc;
    public string $tentochuc;
    public string $tentochuc_en;
    public string $website;
    public string $dienthoai;
    public string $address;
    public TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVm
    public QuocGiaVm $addresscountry; // $id_address_country -- QuocGiaVm
    public PhanLoaiToChucVm $phanloaitochuc; // $id_phanloaitochuc
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

    function getAddressCity()
    {
        return $this->addresscity;
    }

    function setAddressCity(TinhThanhVm $addressCityVm)
    {
        $this->addresscity = $addressCityVm;
    }

    function getAddressCountry()
    {
        return $this->addresscountry;
    }

    function setAddressCountry(QuocGiaVm $addressCountryVm)
    {
        $this->addresscountry = $addressCountryVm;
    }

    function getPhanLoaiToChuc()
    {
        return $this->phanloaitochuc;
    }

    function setPhanLoaiToChuc(PhanLoaiToChucVm $phanLoaiToChucVm)
    {
        $this->phanloaitochuc = $phanLoaiToChucVm;
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
