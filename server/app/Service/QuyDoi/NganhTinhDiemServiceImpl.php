<?php

namespace App\Service\QuyDoi;

use App\Models\QuyDoi\DMNganhTinhDiem;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class NganhTinhDiemServiceImpl implements NganhTinhDiemService
{
    public function getAllNganhTinhDiem(): ResponseSuccess
    {
        $result = [];
        $nganhTinhDiems = DMNganhTinhDiem::all();
        foreach ($nganhTinhDiems as $nganhTinhDiem) {
            $result[] = Convert::getNganhTinhDiemVm($nganhTinhDiem);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
