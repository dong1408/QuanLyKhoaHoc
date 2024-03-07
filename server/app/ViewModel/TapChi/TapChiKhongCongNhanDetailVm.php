<?php

namespace App\ViewModel\TapChi;

use App\ViewModel\User\UserVm;

class TapChiKhongCongNhanDetailVm
{
    public int $id;
    public TapChiVm $tapchi; // $id_tapchi
    public ?bool $khongduoccongnhan;
    public ?string $ghichu;
    public ?UserVm $nguoicapnhat; // $id_nguoicapnhap -- UserVm 
    public string $created_at;
    public string $updated_at;
}
