<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMDonVi;
use Ramsey\Uuid\Type\Integer;

class DonViDetailVm
{
    public int $id;
    public ?ToChucVm $tochuc; // $id_tochuc
    public string $madonvi;
    public ?string $tendonvi;
    public ?string $tendonvi_en;
    public string $created_at;
    public string $updated_at;
}
