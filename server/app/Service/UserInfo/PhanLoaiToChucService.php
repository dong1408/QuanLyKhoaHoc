<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface PhanLoaiToChucService
{
    public function getAllPhanLoaiToChuc(): ResponseSuccess;
}
