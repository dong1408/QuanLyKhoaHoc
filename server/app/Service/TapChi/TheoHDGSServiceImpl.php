<?php

namespace App\Service\TapChi;

use App\Models\TapChi\DMNganhTheoHDGS;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class TheoHDGSServiceImpl implements TheoHDGSService
{
    public function getAllHDGS(): ResponseSuccess
    {
        $hdgss = DMNganhTheoHDGS::all();
        $result = [];
        foreach ($hdgss as $hdgs) {
            $result[] = Convert::getNganhTheoHDGSVm($hdgs);
        }
        return new ResponseSuccess("Thành công",$result);
    }
}
