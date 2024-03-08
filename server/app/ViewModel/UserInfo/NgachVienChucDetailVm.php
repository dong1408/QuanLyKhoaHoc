<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMNgachVienChuc;
use Ramsey\Uuid\Type\Integer;

class NgachVienChucDetailVm
{
    public int $id;
    public string $mangach;
    public ?string $tenngach;
    public ?string $tenngach_en;
    public string $created_at;
    public string $updated_at;
}
