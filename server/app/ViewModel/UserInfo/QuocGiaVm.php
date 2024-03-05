<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMQuocGia;
use Ramsey\Uuid\Type\Integer;

class QuocGiaVm
{
    public int $id;
    public string $maquocgia;
    public ?string $tenquocgia;
    public ?string $tenquocgia_en;
    public string $created_at;
    public string $updated_at;
}
