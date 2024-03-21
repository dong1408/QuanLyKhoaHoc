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

class UserDetailVm
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;
    public int $role;
    public bool $changed;
    public ?string $ngaysinh;
    public ?string $dienthoai;
    public ?string $email2;
    public ?string $orchid;
    public ?ToChucVm $tochuc; // $id_tochuc
    public ?bool $cohuu;
    public ?bool $keodai;
    public ?string $dinhmucnghiavunckh;
    public ?string $dangdihoc;
    public ?ToChucVm $noihoc; // $id_noihoc -- ToChucVm 
    public ?NgachVienChucVm $ngachvienchuc; // $id_ngachvienchuc -- NgachVienChucVm
    public ?QuocGiaVm $quoctich; // $id_quoctich -- QuocGiaVm
    public ?HocHamHocViVm $hochamhocvi; // $id_hochamhocvi
    public ?ChuyenMonVm $chuyenmon; // $id_chuyenmon
    public ?NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public ?ChuyenNganhTinhDiemVm $chuyennganhtinhdiem; // $id_chuyennganhtinhdiem
    public string $created_at;
    public string $updated_at;
    public ?string $deleted_at;
}
