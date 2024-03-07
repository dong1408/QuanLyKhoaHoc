<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\XepHangTapChi;
use App\ViewModel\User\UserVm;
use Ramsey\Uuid\Type\Integer;
use App\ViewModel\TapChi\TapChiVm;

class XepHangTapChiVm
{
    public int $id;
    public ?string $wos;
    public ?string $if;
    public ?string $quartile;
    public ?string $abs;
    public ?string $abcd;
    public ?string $aci;
    public string $created_at;
    public string $updated_at;
}
