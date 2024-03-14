<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface NgachVienChucService
{
    public function getAllNgachVienChuc(): ResponseSuccess;
}
