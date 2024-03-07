<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamRequest;
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
use Symfony\Component\HttpFoundation\Response;

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

    public function getBaiBaoPaging(Request $request): Response
    {
        $result = $this->baiBaoService->getBaiBaoPaging($request);
        return response()->json($result, 200);
    }


    public function getBaiBaoChoDuyet(Request $request): Response
    {
        $result = $this->baiBaoService->getBaiBaoChoDuyet($request);
        return response()->json($result, 200);
    }


    public function getDetailBaiBao(int $id): Response
    {
        $result = $this->baiBaoService->getDetailBaiBao($id);
        return response()->json($result, 200);
    }

    public function createBaiBao(CreateBaiBaoRequest $request): Response
    {
        $result = $this->baiBaoService->createBaiBao($request);
        return response()->json($result, 200);
    }


    public function updateBaiBao(UpdateBaiBaoRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateBaiBao($request, $id);
        return response()->json($result, 200);
    }

    public function updateSanPham(UpdateSanPhamRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateSanPham($request, $id);
        return response()->json($result, 200);
    }


    public function deleteBaiBao(int $id): Response
    {
        $result = $this->baiBaoService->deleteBaiBao($id);
        return response()->json($result, 200);
    }
    public function restoreBaiBao(int $id): Response
    {
        $result = $this->baiBaoService->restoreBaiBao($id);
        return response()->json($result, 200);
    }
    public function forceDeleteBaiBao(int $id): Response
    {
        $result = $this->baiBaoService->forceDeleteBaiBao($id);
        return response()->json($result, 200);
    }

    public function test(Request $request)
    {
        // $tacGias = [1, 3, 4];
        // $vaiTros = [2, 3, 2];

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
        //     SanPhamTacGia::where('id_sanpham', 3)->forceDelete();
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



        $tacGias = [1, 3, 1];
        $vaiTros = [2, 1, 3];

        // kiểm tra 1 người có 2 vai trò giống nhau trong bài báo
        $flag1 = false;
        for ($i = 0; $i < count($tacGias) - 1; $i++) {
            for ($z = $i + 1; $z < count($vaiTros); $z++) {
                if (($tacGias[$i] == $tacGias[$z]) && ($vaiTros[$i] == $vaiTros[$z])) {
                    $flag1 = true;
                    break;
                }
            }
        }

        // Kiểm tra những vai trò quy ước chỉ đc có 1 người đảm nhiểm
        $flag2 = false;
        if ((isset(array_count_values($vaiTros)[2]) && array_count_values($vaiTros)[2] >= 2) || (isset(array_count_values($vaiTros)[1]) && array_count_values($vaiTros)[1] >= 2)) {
            $flag2 = true;
        }

        if ($flag1 || $flag2) {
            return response()->json("trùng");
        }
        return response()->json("Thành công", 200);
    }
}
