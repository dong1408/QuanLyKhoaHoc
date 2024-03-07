<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMQuocGia;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class QuocGiaServiceImpl implements QuocGiaService
{
    public function getAllQuocGia() : ResponseSuccess
    {
        $result = [];
        $quocGias = DMQuocGia::all();
        foreach ($quocGias as $quocGia) {
            $result = Convert::getQuocGiaVm($quocGia);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
