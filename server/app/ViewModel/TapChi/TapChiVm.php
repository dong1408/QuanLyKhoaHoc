<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class TapChiVm
{
    public int $id;
    public string $name;
    public ?string $issn;
    public ?string $eissn;
    public ?string $pissn;
    public ?bool $quocte;
    public ?string $address;
    public ?bool $trangthai;
    public ?UserVm $nguoithem; // $di_nguoithem -- UserVm
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;


    public NhaXuatBanVm $nhaXuatBanVm;
    public ToChucVm $donViChuQuanVm;
    public TinhThanhVm $addressCityVm;
    public QuocGiaVm $addressCountryVm;
    public UserVm $userVm;

    public function __construct()
    {
        // $this->nhaXuatBanVm = new NhaXuatBanVm();
        // $this->donViChuQuanVm = new ToChucVm();
        // $this->addressCityVm = new TinhThanhVm();
        // $this->addressCountryVm = new QuocGiaVm();
        // $this->userVm = new UserVm();
    }

    public function convert(TapChi $tapChi)
    {
        $this->id = $tapChi->id;
        $this->name = $tapChi->name;
        // $this->issn = $tapChi->issn;
        // $this->eissn = $tapChi->eissn;
        // $this->pissn = $tapChi->pissn;
        // $this->website = $tapChi->website;
        // $this->quocte = $tapChi->quocte;
        // $this->nhaxuatban = $this->nhaXuatBanVm->convert($tapChi->nhaXuatBan);
        // $this->donvichuquan = $this->donViChuQuanVm->convert($tapChi->donViChuQuan);
        $this->address = $tapChi->address;
        // $this->addresscity = $this->addressCityVm->convert($tapChi->tinhThanh);
        // $this->addresscountry = $this->addressCountryVm->convert($tapChi->quocGia);
        $this->trangthai = $tapChi->trangthai;
        // $this->nguoithem = $this->userVm->convert($tapChi->nguoiThem);
        // $this->created_at = $tapChi->created_at;
        // $this->updated_at = $tapChi->updated_at;
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

    // function getIssn()
    // {
    //     return $this->issn;
    // }

    // function setIssn($issn)
    // {
    //     $this->issn = $issn;
    // }

    // function getEissn()
    // {
    //     return $this->eissn;
    // }

    // function setEissn($eissn)
    // {
    //     $this->eissn = $eissn;
    // }

    // function getPissn()
    // {
    //     return $this->pissn;
    // }

    // function setPissn($pissn)
    // {
    //     $this->pissn = $pissn;
    // }

    // function getWebsite()
    // {
    //     return $this->website;
    // }

    // function setWebsite($website)
    // {
    //     $this->website = $website;
    // }

    // function getQuocTe()
    // {
    //     return $this->quocte;
    // }

    // function setQuocTe($quocte)
    // {
    //     $this->quocte = $quocte;
    // }

    // function getNhaXuatBan()
    // {
    //     return $this->nhaxuatban;
    // }

    // function setNhaXuatBan(NhaXuatBanVm $nhaXuatBanVm)
    // {
    //     $this->nhaxuatban = $nhaXuatBanVm;
    // }

    // function getDonViChuQuan()
    // {
    //     return $this->donvichuquan;
    // }

    // function setDonViChuQuan(ToChucVm $donViChuQuanVm)
    // {
    //     $this->donvichuquan = $donViChuQuanVm;
    // }

    function getAddress()
    {
        return $this->address;
    }

    function setAddress($address)
    {
        $this->address = $address;
    }

    // function getAddressCity()
    // {
    //     return $this->addresscity;
    // }

    // function setAddressCity(TinhThanhVm $addressCityVm)
    // {
    //     $this->addresscity = $addressCityVm;
    // }

    // function getAddressCountry()
    // {
    //     return $this->addresscountry;
    // }

    // function setAddressCountry(QuocGiaVm $addressCountryVm)
    // {
    //     $this->addresscountry = $addressCountryVm;
    // }

    function getTrangThai()
    {
        return $this->trangthai;
    }

    function setTrangThai($trangthai)
    {
        $this->trangthai = $trangthai;
    }

    // function getNguoiThem()
    // {
    //     return $this->nguoithem;
    // }

    // function setNguoiThem(UserVm $nguoiThemVm)
    // {
    //     $this->nguoithem = $nguoiThemVm;
    // }

    // function getCreatedAt()
    // {
    //     return $this->created_at;
    // }

    // function setCreatedAt($created_at)
    // {
    //     $this->created_at = $created_at;
    // }

    // function getUpdatedAt()
    // {
    //     return $this->updated_at;
    // }

    // function setUpdatedAt($updated_at)
    // {
    //     $this->updated_at = $updated_at;
    // }
}
