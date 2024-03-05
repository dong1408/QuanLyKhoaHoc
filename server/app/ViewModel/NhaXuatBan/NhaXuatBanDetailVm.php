<?php

namespace App\ViewModel\NhaXuatBan;

use App\Models\NhaXuatBan\NhaXuatBan;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Console\Input\StringInput;

class NhaXuatBanDetailVm
{
    public int $id;
    public string $name;
    public string $isbn;
    public string $website;
    public bool $quocte;
    public StringInput $address;
    public TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVm
    public QuocGiaVm $addresscountry; // $id_address_country -- QuocGiaVm
    public ToChucVm $donvichuquan; // $id_donvichuquan -- ToChucVm
    public bool $trangthai;
    public UserVm $nguoithem; // $id_nguoithem -- UserVm
    public string $created_at;
    public string $updated_at;


    private $tinhThanhVm;
    private $quocGiaVm;
    private $donViChuQuanVm;
    private $nguoiThemVm;

    public function __construct()
    {
        $this->tinhThanhVm = new TinhThanhVm();
        $this->quocGiaVm = new QuocGiaVm();
        $this->donViChuQuanVm = new ToChucVm();
        $this->nguoiThemVm = new UserVm();
    }

    public function convert(NhaXuatBan $nhaXuatBan)
    {
        $this->id = $nhaXuatBan->id;
        $this->name = $nhaXuatBan->name;
        $this->isbn = $nhaXuatBan->isbn;
        $this->website = $nhaXuatBan->website;
        $this->quocte = $nhaXuatBan->quocte;
        $this->address = $nhaXuatBan->address;
        $this->addresscity = $this->tinhThanhVm->convert($nhaXuatBan->tinhThanh);
        $this->addresscountry = $this->quocGiaVm->convert($nhaXuatBan->quocGia);
        $this->donvichuquan = $this->donViChuQuanVm->convert($nhaXuatBan->donViChuQuan);
        $this->trangthai = $nhaXuatBan->trangthai;
        $this->nguoithem = $this->nguoiThemVm->convert($nhaXuatBan->nguoiThem);
        $this->created_at = $nhaXuatBan->created_at;
        $this->updated_at = $nhaXuatBan->updated_at;
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
