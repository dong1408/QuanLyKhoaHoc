<?php

namespace App\ViewModel\User;

use App\Models\User;
use Ramsey\Uuid\Type\Integer;

class Me
{
    public int $id;
    public string $name;
    public string $username;
    public string $email;
}
