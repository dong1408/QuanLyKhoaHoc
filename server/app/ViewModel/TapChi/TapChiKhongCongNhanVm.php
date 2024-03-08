<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChiKhongCongNhan;
use App\ViewModel\User\UserVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class TapChiKhongCongNhanVm
{
    public int $id;
    public ?bool $khongduoccongnhan;
    public string $created_at;
    public string $updated_at;
    public UserVm $nguoicapnhat;
    public ?string $ghichu;

}
