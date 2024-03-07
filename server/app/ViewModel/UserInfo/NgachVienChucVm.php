<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMNgachVienChuc;
use Ramsey\Uuid\Type\Integer;

class NgachVienChucVm
{
    public int $id;
    public ?string $tenngach;
    public string $created_at;
    public string $updated_at;
}
