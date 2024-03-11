<?php

namespace App\Service\NhaXuatBan;

use App\Utilities\ResponseSuccess;

interface NhaXuatBanService
{
    public function getAllNhaXuatBan(): ResponseSuccess;
}
