<?php

namespace App\ViewModel\TapChi;

use App\Models\DMPhanLoaiTapChi;
use Ramsey\Uuid\Type\Integer;

class PhanLoaiTapChiDetailVm
{
    public int $id;
    public string $ma;
    public ?string $ten;
    public string $created_at;
    public string $updated_at;
}
