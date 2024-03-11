<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\DMSanPham;
use Ramsey\Uuid\Type\Integer;

class DMSanPhamDetailVm
{
    public int $id;
    public string $madmsanpham;
    public string $tendmsanpham;
    public ?string $mota;
    public string $created_at;
    public string $updated_at;
}
