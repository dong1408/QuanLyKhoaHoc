<?php

namespace App\ViewModel\NhaXuatBan;

use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Console\Input\StringInput;

class NhaXuatBanVm
{
    public Integer $id;
    public string $name;
    public string $isbn;
    public string $website;
    public Boolean $quocte;
    public StringInput $address;
    public TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVm
    public QuocGiaVm $addresscountry; // $id_address_country -- QuocGiaVm
    public ToChucVm $donvichuquan; // $id_donvichuquan -- ToChucVm
    public Boolean $trangthai;
    public UserVm $nguoithem; // $id_nguoithem -- UserVm
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

    function getName()
    {
        return $this->name;
    }

    function setName($name)
    {
        $this->name = $name;
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

    function getDonViChuQuan()
    {
        return $this->donvichuquan;
    }

    function setDonViChuQuan(ToChucVm $donViChuQuanVm)
    {
        $this->donvichuquan = $donViChuQuanVm;
    }

    function getTrangThai()
    {
        return $this->trangthai;
    }

    function setTrangThai($trangthai)
    {
        $this->trangthai = $trangthai;
    }

    function getNguoiThem()
    {
        return $this->nguoithem;
    }

    function setNguoiThem(UserVm $nguoiThemVm)
    {
        $this->nguoithem = $nguoiThemVm;
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
