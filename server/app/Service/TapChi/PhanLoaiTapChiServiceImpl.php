<?php

namespace App\Service\TapChi;

use App\Exceptions\TapChi\TapChiNotFoundException;
use App\Models\TapChi\DMPhanLoaiTapChi;
use App\Models\TapChi\TapChi;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class PhanLoaiTapChiServiceImpl implements PhanLoaiTapChiService
{
    public function getPhanLoaiByTapChiId(int $id_tapchi): ResponseSuccess
    {
        $id_tapchi = (int) $id_tapchi;
        $tapChi = TapChi::withTrashed()->find($id_tapchi);
        if ($tapChi == null) {
            throw new TapChiNotFoundException();
        }
        $phanLoaiTapChis = $tapChi->dmPhanLoaiTapChis;
        $result = [];
        foreach ($phanLoaiTapChis as $phanLoaiTapChi) {
            $result[] = Convert::getDMPhanLoaiTapChiVm($phanLoaiTapChi);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getAllPhanLoaiTapChi():ResponseSuccess{
        $tapChis = DMPhanLoaiTapChi::all();
        $result = [];
        foreach ($tapChis as $tapChi) {
            $result[] = Convert::getDMPhanLoaiTapChiVm($tapChi);
        }
        return new ResponseSuccess("Thành công",$result);
    }
}
