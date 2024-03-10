<?php

namespace App\Service\DeTai;

use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Models\DeTai\DeTai;
use App\Models\SanPham\SanPham;
use App\Service\DeTai\DeTaiService;
use App\Utilities\ResponseSuccess;
use Illuminate\Support\Facades\DB;

class DeTaiServiceImple implements DeTaiService
{
    public function getDeTaiPaging(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }


    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess
    {
        $validated = $request->validated();

        $deTai = new DeTai();
        $sanPham = new SanPham();

        DB::transaction(function () use ($validated, &$deTai, &$sanPham) {
            
        });

        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }
    public function updateDeTai(): ResponseSuccess
    {
        return new ResponseSuccess("Thành công", true);
    }
    public function updateSanPham(): ResponseSuccess
    {
        return new ResponseSuccess("Thành công", true);
    }
    public function updateVaiTroTacGia(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }

    public function tuyenChonDeTai(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }

    public function xetDuyetDeTai(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }
    public function baoCaoTienDoDeTai(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }
    public function nghiemThuDeTai(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }
    public function getPhanLoaiDeTai(): ResponseSuccess
    {
        $result = [];
        return new ResponseSuccess("Thành công", $result);
    }
}
