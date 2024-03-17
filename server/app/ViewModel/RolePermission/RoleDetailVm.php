<?php

namespace App\ViewModel\RolePermission;

class RoleDetailVm
{
    public int $id;
    public string $name;
    public string $mavaitro;
    public ?string $description;
    public ?string $created_at;
    public ?string $updated_at;

    public ?array $permissions;
}
