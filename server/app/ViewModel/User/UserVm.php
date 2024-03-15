<?php

namespace App\ViewModel\User;

use App\Models\User;
use App\ViewModel\QuyDoi\ChuyenNganhTinhDiemVm;
use App\ViewModel\QuyDoi\NganhTinhDiemVm;
use App\ViewModel\UserInfo\ChuyenMonVm;
use App\ViewModel\UserInfo\DonViVm;
use App\ViewModel\UserInfo\HocHamHocViVm;
use App\ViewModel\UserInfo\NgachVienChucVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class UserVm
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public ?string $deleted_at;

    public  $roles;
}
