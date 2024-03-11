<?php

namespace App\ViewModel\SanPham;

use App\Models\SanPham\DMSanPham;
use Ramsey\Uuid\Type\Integer;

class DMSanPhamVm
{
    public int $id;
    public string $tendmsanpham;
    public string $created_at;
    public ?string $mota;
    public string $madmsanpham;
    public string $updated_at;
}

?>
