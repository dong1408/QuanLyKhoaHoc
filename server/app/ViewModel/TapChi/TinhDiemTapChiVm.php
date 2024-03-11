<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\Models\TapChi\TinhDiemTapChi;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\User\UserVm;

class TinhDiemTapChiVm
{
    public int $id;
    public ?string $diem;
    public ?string $namtinhdiem;
    public string $created_at;
    public string $updated_at;
    public UserVm $nguoicapnhat;
    public ?string $ghichu;
    public ?NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public ?ChuyenNganhTinhDiemVm $chuyennganhtinhdiem; // $id_chuyennganhtinhdiem
}
