<?php

namespace App\Http\Controllers\Admin\DeTai;

use App\Http\Controllers\Controller;
use App\Http\Requests\Detai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Http\Requests\Detai\NghiemThuDeTaiRequest;
use App\Http\Requests\Detai\TuyenChonDeTaiRequest;
use App\Http\Requests\Detai\UpdateDeTaiRequest;
use App\Http\Requests\Detai\XetDuyetDeTaiRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Service\DeTai\DeTaiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeTaiController extends Controller
{
    private DeTaiService $deTaiService;
    public function __construct(DeTaiService $deTaiService)
    {
        $this->deTaiService = $deTaiService;
        $this->middleware('auth:api');
    }

    public function getDeTaiPaging(Request $request): response
    {
        $result = $this->deTaiService->getDeTaiPaging($request);
        return response()->json($result, 200);
    }

    public function getDeTaiChoDuyet(Request $request): response
    {
        $result = $this->deTaiService->getDeTaiChoDuyet($request);
        return response()->json($result, 200);
    }

    public function getDetailDeTai(int $id): response
    {
        $result = $this->deTaiService->getDetailDeTai($id);
        return response()->json($result, 200);
    }


    public function getDetailDeTaiForUser(int $id): response
    {
        $result = $this->deTaiService->getDetailDeTaiForUser($id);
        return response()->json($result, 200);
    }

    public function createDeTai(CreateDeTaiRequest $request): response
    {
        $result = $this->deTaiService->createDeTai($request);
        return response()->json($result, 200);
    }

    public function updateSanPham(UpdateSanPhamRequest $request, int $id): response
    {
        $result = $this->deTaiService->updateSanPham($request, $id);
        return response()->json($result, 200);
    }

    public function updateDeTai(UpdateDeTaiRequest $request, int $id): response
    {
        $result = $this->deTaiService->updateDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): response
    {
        $result = $this->deTaiService->updateSanPhamTacGia($request, $id);
        return response()->json($result, 200);
    }

    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): response
    {
        $result = $this->deTaiService->updateFileMinhChung($request, $id);
        return response()->json($result, 200);
    }
    public function updateTrangThaiRaSoatDeTai(UpdateTrangThaiRaSoatRequest $request, int $id): response
    {
        $result = $this->deTaiService->updateTrangThaiRaSoatDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function tuyenChonDeTai(TuyenChonDeTaiRequest $request, int $id): response
    {
        $result = $this->deTaiService->tuyenChonDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request, int $id): response
    {
        $result = $this->deTaiService->xetDuyetDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request, int $id): response
    {
        $result = $this->deTaiService->baoCaoTienDoDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request, int $id): response
    {
        $result = $this->deTaiService->nghiemThuDeTai($request, $id);
        return response()->json($result, 200);
    }

    public function getLichSuBaoCao(Request $request, int $id): response
    {
        $result = $this->deTaiService->getLichSuBaoCao($request, $id);
        return response()->json($result, 200);
    }


    public function deleteDeTai(int $id): response
    {
        $result = $this->deTaiService->deleteDeTai($id);
        return response()->json($result, 200);
    }

    public function restoreDeTai(int $id): response
    {
        $result = $this->deTaiService->restoreDeTai($id);
        return response()->json($result, 200);
    }

    public function forceDeleteDeTai(int $id): response
    {
        $result = $this->deTaiService->forceDeleteDeTai($id);
        return response()->json($result, 200);
    }
}
