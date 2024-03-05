<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMTinhThanh;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class TinhThanhServiceImpl implements TinhThanhService
{
    public function getAllTinhThanh() : ResponseSuccess
    {
        $result = [];
        $tinhThanhs = DMTinhThanh::all();
        foreach ($tinhThanhs as $tinhThanh) {
            $result[] = Convert::getTinhThanhVm($tinhThanh);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
