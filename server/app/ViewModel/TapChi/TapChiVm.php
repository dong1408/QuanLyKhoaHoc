<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\ViewModel\NhaXuatBan\NhaXuatBanVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;

class TapChiVm
{
    public int $id;
    public string $name;
    public ?string $address;
    public ?bool $trangthai;
    public ?bool $khongduoccongnhan;
    public ?UserVm $nguoithem; // $di_nguoithem -- UserVm
    public string $created_at;
    public string $updated_at;
}
