<?php

namespace App\ViewModel\QuyDoi;

use App\Models\QuyDoi\DMNganhTinhDiem;

class NganhTinhDiemVm
{
    public int $id;
    public ?string $tennganhtinhdiem;
    public string $manganhtinhdiem;
    public ?string $tennganh_en;
    public string $created_at;
    public string $updated_at;
}
