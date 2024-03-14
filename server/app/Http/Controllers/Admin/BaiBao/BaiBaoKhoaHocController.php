<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Service\BaiBao\BaiBaoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BaiBaoKhoaHocController extends Controller
{
    private BaiBaoService $baiBaoService;

    public function __construct(BaiBaoService $baiBaoService)
    {
        $this->baiBaoService = $baiBaoService;
        $this->middleware('auth:api');
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

    public function updateSanPham(UpdateSanPhamRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateSanPham($request, $id);
        return response()->json($result, 200);
    }

    public function updateBaiBao(UpdateBaiBaoRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateBaiBao($request, $id);
        return response()->json($result, 200);
    }

    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateSanPhamTacGia($request, $id);
        return response()->json($result, 200);
    }

    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateFileMinhChung($request, $id);
        return response()->json($result, 200);
    }

    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatRequest $request, $id): Response
    {
        $result = $this->baiBaoService->updateTrangThaiRaSoatBaiBao($request, $id);
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

    public function getBaiBaoKeKhai(Request $request): Response
    {
        $result = $this->baiBaoService->getBaiBaoKeKhai($request);
        return response()->json($result, 200);
    }

    public function getBaiBaoThamGia(Request $request): Response
    {
        $result = $this->baiBaoService->getBaiBaoThamGia($request);
        return response()->json($result, 200);
    }
}
