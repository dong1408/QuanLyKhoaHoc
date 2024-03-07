<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\TapChi;
use App\Models\TapChi\TinhDiemTapChi;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\User\UserVm;

class TinhDiemTapChiDetailVm
{
    public int $id;
    public ?TapChiVm $tapchi; // $id_tapchi
    public ?NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public ?ChuyenNganhTinhDiemVm $chuyennganhtinhdiem; // $id_chuyennganhtinhdiem
    public ?string $diem;
    public ?string $namtinhdiem;
    public ?UserVm $nguoicapnhat; // $id_nguoicapnhat -- UserVm
    public ?string $ghichu;
    public string $created_at;
    public string $updated_at;
}
