<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMChuyenMon;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class ChuyenMonServiceImpl implements ChuyenMonService
{
    public function getAllChuyenMon(): ResponseSuccess
    {
        $result = [];
        $chuyenMons = DMChuyenMon::all();
        foreach ($chuyenMons as $chuyenMon) {
            $result[] = Convert::getChuyenMonVm($chuyenMon);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
