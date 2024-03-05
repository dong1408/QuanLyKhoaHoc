<?php

namespace App\ViewModel\TapChi;

use App\Models\DMNganhTheoHSGS;
use Ramsey\Uuid\Type\Integer;

class NganhTheoHDGSVm
{
    public int $id;
    public string $ma;
    public ?string $ten;
    public string $created_at;
    public string $updated_at;

}
