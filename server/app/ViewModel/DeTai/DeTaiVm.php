<?php

namespace App\ViewModel\DeTai;

use App\Models\DeTai\DeTai;
use App\Models\SanPham\SanPham;
use App\ViewModel\SanPham\SanPhamVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;

class DeTaiVm
{
    public int $id;
    public string $tensanpham;
    public int $id_sanpham;
    public string $trangthai;
    public string $maso;
    public ?string $ngaydangky;
    public ?string $capdetai;
    public $created_at;
    public $updated_at;
    public ?string $deleted_at;
    public string $trangthairasoat;
}
