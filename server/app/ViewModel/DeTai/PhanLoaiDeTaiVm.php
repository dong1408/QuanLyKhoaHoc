<?php

namespace App\ViewModel\DeTai;

use App\Models\DeTai\PhanLoaiDeTai;
use Ramsey\Uuid\Type\Integer;

class PhanLoaiDeTaiVm
{
    public int $id;
    public ?string $maloai;
    public string $tenloai;
    public ?string $kinhphi;
    public ?string $mota;
    public string $created_at;
    public string $updated_at;
}
