<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMHocHamHocVi;
use Ramsey\Uuid\Type\Integer;

class HocHamHocViVm
{
    public int $id;
    public ?string $tenhochamhocvi;
    public string $created_at;
    public string $updated_at;
}
