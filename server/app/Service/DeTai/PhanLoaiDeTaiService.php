<?php

namespace App\Service\DeTai;

use App\Utilities\ResponseSuccess;

interface PhanLoaiDeTaiService
{
    public function getPhanLoaiDeTai(): ResponseSuccess;
}
