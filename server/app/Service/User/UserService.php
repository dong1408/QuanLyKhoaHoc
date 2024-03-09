<?php

namespace App\Service\User;

use App\Utilities\ResponseSuccess;

interface UserService
{
    public function getAllUser(): ResponseSuccess;
}
