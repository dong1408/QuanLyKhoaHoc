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
}
