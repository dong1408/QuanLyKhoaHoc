<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface ChuyenMonService
{
    public function getAllChuyenMon(): ResponseSuccess;
}
