<?php

namespace App\Service\QuyDoi;

use App\Models\QuyDoi\DMChuyenNganhTinhDiem;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class ChuyenNganhTinhDiemServiceImpl implements ChuyenNganhTinhDiemService
{
    public function getAllChuyenNganhTinhDiem(): ResponseSuccess
    {
        $result = [];
        $chuyenNganhTinhDiems = DMChuyenNganhTinhDiem::all();
        foreach ($chuyenNganhTinhDiems as $chuyenNganhTinhDiem) {
            $result[] = Convert::getChuyenNganhTinhDiemVm($chuyenNganhTinhDiem);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getChuyeNganhTinhDiemByIdNganhTinhDiem(int $id)
    {
        $result = [];
        $chuyenNganhTinhDiems = DMChuyenNganhTinhDiem::where('id_nganhtinhdiem',$id)->get();
        foreach ($chuyenNganhTinhDiems as $chuyenNganhTinhDiem) {
            $result[] = Convert::getChuyenNganhTinhDiemVm($chuyenNganhTinhDiem);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
