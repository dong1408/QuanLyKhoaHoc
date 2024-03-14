<?php

namespace App\ViewModel\DeTai;

use App\Models\DeTai\BaoCaoTienDo;
use App\ViewModel\SanPham\SanPhamVm;
use Ramsey\Uuid\Type\Integer;

class BaoCaoTienDoVm
{
    public int $id;
    public ?string $ngaynopbaocao;
    public ?string $ketquaxet;
    public ?string $thoigiangiahan;
    public string $created_at;
    public string $updated_at;
}
