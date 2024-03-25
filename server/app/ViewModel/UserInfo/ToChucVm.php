<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMToChuc;
use Ramsey\Uuid\Type\Integer;

class ToChucVm
{
    public int $id;
    public ?string $tentochuc;
    public string $created_at;
    public string $updated_at;
    public string $matochuc;
    public ?string $tentochuc_en;
    public ?string $dienthoai;
    public ?string $website;
}
