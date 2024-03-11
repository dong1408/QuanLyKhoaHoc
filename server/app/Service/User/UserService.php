<?php

namespace App\Service\User;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface UserService
{
    public function getAllUser(Request $request): ResponseSuccess;
}
