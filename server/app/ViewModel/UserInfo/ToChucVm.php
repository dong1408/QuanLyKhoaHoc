<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMToChuc;
use Ramsey\Uuid\Type\Integer;

class ToChucVm
{
    public int $id;
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

    private $tinhThanhVm;
    private $quocGiaVm;
    private $phanLoaiToChucVm;

    public function __construct()
    {
        $this->tinhThanhVm = new TinhThanhVm();
        $this->quocGiaVm = new QuocGiaVm();
        $this->phanLoaiToChucVm = new PhanLoaiToChucVm();
    }

    public function convert(DMToChuc $dmToChuc)
    {
        $this->id = $dmToChuc->id;
        $this->matochuc = $dmToChuc->matochuc;
        $this->tentochuc = $dmToChuc->tentochuc;
        $this->tentochuc_en = $dmToChuc->tentochuc_en;
        $this->website = $dmToChuc->website;
        $this->dienthoai = $dmToChuc->dienthoai;
        $this->address = $dmToChuc->address;
        $this->addresscity = $this->tinhThanhVm->convert($dmToChuc->tinhThanh);
        $this->addresscountry = $this->quocGiaVm->convert($dmToChuc->quocGia);
        $this->phanloaitochuc = $this->phanLoaiToChucVm->convert($dmToChuc->phanLoaiToChuc);
        $this->created_at = $dmToChuc->created_at;
        $this->updated_at = $dmToChuc->updated_at;
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
