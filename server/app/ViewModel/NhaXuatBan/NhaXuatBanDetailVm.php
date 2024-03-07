<?php

namespace App\ViewModel\NhaXuatBan;

use App\Models\NhaXuatBan\NhaXuatBan;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use Symfony\Component\Console\Input\StringInput;

class NhaXuatBanDetailVm
{
    public int $id;
    public string $name;
    public ?string $isbn;
    public ?string $website;
    public ?bool $quocte;
    public ?string $address;
    public ?TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVm
    public ?QuocGiaVm $addresscountry; // $id_address_country -- QuocGiaVm
    public ?ToChucVm $donvichuquan; // $id_donvichuquan -- ToChucVm
    public ?bool $trangthai;
    public ?UserVm $nguoithem; // $id_nguoithem -- UserVm
    public string $created_at;
    public string $updated_at;
}
