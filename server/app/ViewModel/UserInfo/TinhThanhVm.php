<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMTinhThanh;
use Ramsey\Uuid\Type\Integer;

class TinhThanhVm
{
    public int $id;
    public ?string $tentinhthanh;
    public ?string $created_at;
    public ?string $updated_at;
}
