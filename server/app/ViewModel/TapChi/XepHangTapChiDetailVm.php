<?php

namespace App\ViewModel\TapChi;

use App\Models\TapChi\XepHangTapChi;
use App\ViewModel\User\UserVm;
use Ramsey\Uuid\Type\Integer;

class XepHangTapChiDetailVm
{
    public int $id;
    public TapChiVm $tapchi; // $id_tapchi
    public ?string $wos;
    public ?string $if;
    public ?string $quartile;
    public ?string $abs;
    public ?string $abcd;
    public ?string $aci;
    public ?string $ghichu;
    public ?UserVm $user; // $id_user
    public string $created_at;
    public string $updated_at;
}
