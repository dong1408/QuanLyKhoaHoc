<?php

namespace App\Service\UserInfo;

use App\Exceptions\UserInfo\QuocGiaNotFoundException;
use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMTinhThanh;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class TinhThanhServiceImpl implements TinhThanhService
{
    public function getAllTinhThanh(): ResponseSuccess
    {
        $result = [];
        $tinhThanhs = DMTinhThanh::all();
        foreach ($tinhThanhs as $tinhThanh) {
            $result[] = Convert::getTinhThanhVm($tinhThanh);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getAllTinhThanhByIdQuocGia(int $id) : ResponseSuccess
    {
        $id_quocgia = (int) $id;
        $quocGia = DMQuocGia::find($id_quocgia);
        if ($quocGia == null) {
            throw new QuocGiaNotFoundException();
        }
        $tinhThanhs = $quocGia->tinhThanhs;
        $result = [];
        foreach ($tinhThanhs as $tinhThanh) {
            $result[] = Convert::getTinhThanhVm($tinhThanh);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
