<?php

namespace App\ViewModel\QuyDoi;

use App\Models\QuyDoi\DMChuyenNganhTinhDiem;

class ChuyenNganhTinhDiemVm
{
    public int $id;
    public string $machuyennganh;
    public ?string $tenchuyennganh;
    public ?string $tenchuyennganh_en;
    public string $created_at;
    public string $updated_at;
}
