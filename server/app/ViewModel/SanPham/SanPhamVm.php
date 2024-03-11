<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\SanPham;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class SanPhamVm
{
    public int $id;
    public string $tensanpham;
    public ?DMSanPhamVm $loaisanpham; // $id_loaisanpham -- DMSanPhamVm
    public int $tongsotacgia;
    public ?int $solandaquydoi;
    public ?UserVm $nguoikekhai;
    public string $diemquydoi;
    public string $gioquydoi;
    public string $capsanpham;
    public ?string $thoidiemcongbohoanthanh;
    public string $created_at;
    public string $updated_at;
}
