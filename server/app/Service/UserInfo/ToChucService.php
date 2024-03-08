<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface ToChucService
{
    public function getAllToChuc(): ResponseSuccess;
}
