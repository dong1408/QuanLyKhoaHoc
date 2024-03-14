<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMNgachVienChuc;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class NgachVienChucServiceImpl implements NgachVienChucService
{
    public function getAllNgachVienChuc(): ResponseSuccess
    {
        $result = [];
        $ngachVienChucs = DMNgachVienChuc::all();
        foreach ($ngachVienChucs as $ngachVienChuc) {
            $result[] = Convert::getNgachVienChucVm($ngachVienChuc);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
