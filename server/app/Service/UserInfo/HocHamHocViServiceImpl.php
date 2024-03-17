<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMHocHamHocVi;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class HocHamHocViServiceImpl implements HocHamHocViService
{
    public function getAllHocHamHocVi(): ResponseSuccess
    {
        $result = [];
        $hochamhocvis = DMHocHamHocVi::all();
        foreach ($hochamhocvis as $hochamhocvi) {
            $result[] = Convert::getHocHamHocViVm($hochamhocvi);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
