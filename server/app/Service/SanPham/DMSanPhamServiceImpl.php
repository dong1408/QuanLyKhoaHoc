<?php

namespace App\Service\SanPham;

use App\Models\SanPham\DMSanPham;
use App\Utilities\ResponseSuccess;

class DMSanPhamServiceImpl implements DMSanPhamService
{
    public function getDmSanPham(): ResponseSuccess
    {
        $result = DMSanPham::all();
        return new ResponseSuccess("Thành công", $result);
    }
}
