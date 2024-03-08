<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMToChuc;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class ToChucServiceImpl implements ToChucService
{
    public function getAllToChuc(): ResponseSuccess
    {
        $result = [];
        $toChucs = DMToChuc::all();
        foreach ($toChucs as $toChuc) {
            $result[] = Convert::getToChucVm($toChuc);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
