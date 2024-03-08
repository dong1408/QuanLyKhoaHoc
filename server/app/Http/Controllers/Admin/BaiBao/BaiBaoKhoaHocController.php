<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\User;
use App\Models\UserInfo\DMTinhThanh;
use App\Models\UserInfo\DMQuocGia;
use App\Service\BaiBao\BaiBaoService;
use App\Utilities\ResponseError;
use App\ViewModel\BaiBao\BaiBaoKhoaHocVm;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BaiBaoKhoaHocController extends Controller
{
    private BaiBaoService $baiBaoService;

    public function __construct(BaiBaoService $baiBaoService)
    {
        $this->baiBaoService = $baiBaoService;
        $this->middleware('auth:api');
    }

    public function getDMSanPham()
    {
    }

    public function getBaiBaoPaging(Request $request)
    {
        $result = $this->baiBaoService->getBaiBaoPaging($request);
        return response()->json($result, 200);
    }


    public function getBaiBaoChoDuyet(Request $request)
    {
        $result = $this->baiBaoService->getBaiBaoChoDuyet($request);
        return response()->json($result, 200);
    }


    public function getDetailBaiBao(int $id)
    {
        $result = $this->baiBaoService->getDetailBaiBao($id);
        return response()->json($result, 200);
    }

    public function createBaiBao(CreateBaiBaoRequest $request)
    {
        $result = $this->baiBaoService->createBaiBao($request);
        return response()->json($result, 200);
    }


    public function updateBaiBao(CreateBaiBaoRequest $request)
    {
    }
    public function deleteBaiBao(int $id)
    {
    }
    public function restoreBaiBao(int $id)
    {
    }
    public function forceDeleteBaiBao(int $id)
    {
    }

    public function test(Request $request)
    {
        $tacGias = [1, 3, 4];
        $vaiTros = [2, 2, 2];

        // insert
        // $flag = false;
        // for ($i = 0; $i < count($tacGias) - 1; $i++) {
        //     for ($z = $i + 1; $z < count($vaiTros); $z++) {
        //         if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
        //             $flag = true;
        //             break;
        //         }
        //     }
        // }
        // if (!$flag) {
        //     for ($i = 0; $i < count($tacGias); $i++) {
        //         $tacGiaId = $tacGias[$i];
        //         $vaiTroId = $vaiTros[$i];

        //         SanPhamTacGia::create([
        //             'id_sanpham' => 3,
        //             'id_tacgia' => $tacGiaId,
        //             'id_vaitrotacgia' => $vaiTroId
        //         ]);
        //     }
        // }



        // update
        $flag = false;
        for ($i = 0; $i < count($tacGias) - 1; $i++) {
            for ($z = $i + 1; $z < count($vaiTros); $z++) {
                if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
                    $flag = true;
                    break;
                }
            }
        }
        if (!$flag) {
            SanPhamTacGia::where('id_sanpham', 3)->forceDelete();
            for ($i = 0; $i < count($tacGias); $i++) {
                $tacGiaId = $tacGias[$i];
                $vaiTroId = $vaiTros[$i];

                SanPhamTacGia::create([
                    'id_sanpham' => 3,
                    'id_tacgia' => $tacGiaId,
                    'id_vaitrotacgia' => $vaiTroId
                ]);
            }
        }


        return response()->json("Thành công", 200);
    }
}
