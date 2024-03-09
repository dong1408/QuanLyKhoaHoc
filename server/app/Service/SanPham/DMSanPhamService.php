<?php

namespace App\Service\SanPham;

use App\Utilities\ResponseSuccess;

interface DMSanPhamService
{
    public function getDmSanPham(): ResponseSuccess;
}
