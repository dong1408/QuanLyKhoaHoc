<?php

namespace App\Service\DeTai;

use App\Models\DeTai\PhanLoaiDeTai;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class  PhanLoaiDeTaiServiceImpl implements PhanLoaiDeTaiService
{
    public function getPhanLoaiDeTai(): ResponseSuccess
    {
        $phanLoaiDeTais = PhanLoaiDeTai::all();
        $result = [];
        foreach ($phanLoaiDeTais as $phanLoaiDeTai) {
            $result[] = Convert::getPhanLoaiDeTaiVm($phanLoaiDeTai);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
