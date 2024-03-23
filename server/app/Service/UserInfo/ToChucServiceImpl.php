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
        $result = [];
        if (!empty($keysearch)) {
            $toChucs = DMToChuc::where('name', 'LIKE', '%' . $keysearch . '%')->take(10)->get();
            foreach ($toChucs as $toChuc) {
                $result[] = Convert::getToChucVm($toChuc);
            }
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function themToChucNgoai($array): DMToChuc
    {
        $toChuc = DMToChuc::create([
            'matochuc' => $array['matochuc'],
            'tentochuc' => $array['tentochuc']
        ]);
        return $toChuc;
    }
}
