<?php

use App\Models\DeTai\BaoCaoTienDo;
use App\ViewModel\SanPham\SanPhamVm;
use Ramsey\Uuid\Type\Integer;

class BaoCaoTienDoDetailVm
{
    public int $id;
    public SanPhamVm $sanpham; // $id_sanpham
    public ?string $ngaynopbaocao;
    public ?string $ketquaxet;
    public ?string $thoigiangiahan;
    public string $created_at;
    public string $updated_at;
}
