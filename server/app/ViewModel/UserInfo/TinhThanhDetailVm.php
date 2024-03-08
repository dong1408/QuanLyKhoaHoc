<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMTinhThanh;
use Ramsey\Uuid\Type\Integer;

class TinhThanhDetailVm
{
    public int $id;
    public ?QuocGiaVm $quocgia;
    public string $matinhthanh;
    public ?string $tentinhthanh;
    public ?string $tentinhthanh_en;
    public string $created_at;
    public string $updated_at;
}
