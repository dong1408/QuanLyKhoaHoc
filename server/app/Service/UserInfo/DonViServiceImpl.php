<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMDonVi;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class DonViServiceImpl implements DonViService
{
    public function getAllDonVi(): ResponseSuccess
    {
        $result = [];
        $donVis = DMDonVi::all();
        foreach ($donVis as $donVi) {
            $result[] = Convert::getDonViVm($donVi);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getDonViByIdToChuc(int $id): ResponseSuccess
    {
        $result = [];
        $donVis = DMDonVi::where('id_tochuc',$id)->get();
        foreach ($donVis as $donVi) {
            $result[] = Convert::getDonViVm($donVi);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
