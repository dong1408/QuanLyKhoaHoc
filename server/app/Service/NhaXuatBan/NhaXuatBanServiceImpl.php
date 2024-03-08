<?php

namespace App\Service\NhaXuatBan;

use App\Models\NhaXuatBan\NhaXuatBan;
use App\Models\UserInfo\DMQuocGia;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class NhaXuatBanServiceImpl implements NhaXuatBanService
{
    public function getAllNhaXuatBan(): ResponseSuccess
    {
        $result = [];
        $nhaXuatBans = NhaXuatBan::all();
        foreach ($nhaXuatBans as $nhaXuatBan) {
            $result[] = Convert::getNhaXuatBanVm($nhaXuatBan);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
