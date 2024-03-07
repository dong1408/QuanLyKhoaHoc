<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMChuyenMon;

class ChuyenMonDetailVm
{
    public int $id;
    public string $machuyenmon;
    public ?string $tenchuyenmon;
    public ?string $tenchuyenmon_en;
    public string $created_at;
    public string $updated_at;
}
