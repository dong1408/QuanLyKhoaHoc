<?php

namespace App\ViewModel\RolePermission;

class PermissionVm
{
    public int $id;
    public string $name;
    public string $slug;
    public ?string $description;
    public ?string $created_at;
    public ?string $updated_at;
}
