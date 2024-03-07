<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMHocHamHocVi;
use Ramsey\Uuid\Type\Integer;

class HocHamHocViDetailVm
{
    public int $id;
    public string $mahochamhocvi;
    public ?string $tenhochamhocvi;
    public ?string $tenhochamhocvi_en;
    public string $created_at;
    public string $updated_at;
}
