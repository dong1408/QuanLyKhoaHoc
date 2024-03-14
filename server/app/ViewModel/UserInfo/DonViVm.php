<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMDonVi;
use Ramsey\Uuid\Type\Integer;

class DonViVm
{
    public int $id;
    public ?string $tendonvi;
    public ?string $created_at;
    public ?string $updated_at;
}
