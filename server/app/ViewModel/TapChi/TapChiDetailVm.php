<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class TapChiDetailVm
{
    public int $id;
    public string $name;
    public ?string $issn;
    public ?string $eissn;
    public ?string $pissn;
    public ?string $website;
    public ?bool $quocte;
    public ?NhaXuatBanVm $nhaxuatban; // $id_nhaxuatban
    public ?ToChucVm $donvichuquan; // $id_donvichuquan -- ToChucVm
    public ?string $address;
    public ?TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVM
    public ?QuocGiaVm $addresscountry; // id_address_country -- QuocGiaVm
    public ?bool $trangthai;
    public ?UserVm $nguoithem; // $di_nguoithem -- UserVm
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;

    public ?TapChiKhongCongNhanVm $khongduoccongnhan;

    public ?XepHangTapChiDetailVm $xephangtapchi;

    public ?TinhDiemTapChiDetailVm $tinhdiemtapchi;
}
