<?php

namespace App\ViewModel\DeTai;

use App\Models\DeTai\XetDuyet;
use App\ViewModel\SanPham\SanPhamVm;

class TuyenChonVm
{
    public int $id;
    public string $ketquatuyenchon;
    public ?string $lydo;
    public string $created_at;
    public string $updated_at;

}
