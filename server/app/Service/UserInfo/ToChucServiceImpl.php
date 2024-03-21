<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMQuocGia;
use App\Models\UserInfo\DMToChuc;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

class ToChucServiceImpl implements ToChucService
{
    public function getAllToChuc(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");
        $toChucs = DMToChuc::where('name', 'LIKE', '%' . $keysearch . '%')->get();
        $result = [];
        foreach ($toChucs as $toChuc) {
            $result[] = Convert::getToChucVm($toChuc);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
