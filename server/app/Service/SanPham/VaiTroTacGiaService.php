<?php

namespace App\Service\SanPham;

use App\Utilities\ResponseSuccess;

interface VaiTroTacGiaService
{
    public function getVaiTroOfBaiBao(): ResponseSuccess;
    public function getVaiTroOfDeTai(): ResponseSuccess;
}
