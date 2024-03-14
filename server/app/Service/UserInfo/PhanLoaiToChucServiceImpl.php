<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMPhanLoaiToChuc;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class PhanLoaiToChucServiceImpl implements PhanLoaiToChucService
{
    public function getAllPhanLoaiToChuc(): ResponseSuccess
    {
        $result = [];
        $phanLoaiToChucs = DMPhanLoaiToChuc::all();
        foreach ($phanLoaiToChucs as $phanLoaiToChuc) {
            $result[] = Convert::getPhanLoaiToChucVm($phanLoaiToChuc);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
