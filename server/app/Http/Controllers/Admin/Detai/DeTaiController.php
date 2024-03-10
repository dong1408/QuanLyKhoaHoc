<?php

namespace App\Http\Controllers\Admin\DeTai;

use App\Http\Controllers\Controller;
use App\Http\Requests\Detai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Http\Requests\Detai\NghiemThuDeTaiRequest;
use App\Http\Requests\Detai\UpdateDeTaiRequest;
use App\Http\Requests\Detai\XetDuyetDeTaiRequest;
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

    public function getDeTaiPaging(): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function createDeTai(CreateDeTaiRequest $request): Response
    {
        $result = $this->deTaiService->createDeTai($request);
        return response()->json($result, 200);
    }


    public function updateDeTai(UpdateDeTaiRequest $request): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function updateSanPham(): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function updateVaiTroTacGia(): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request): Response
    {
        $result = [];
        return response()->json($result, 200);
    }


    public function getPhanLoaiDeTai(): Response
    {
        $result = [];
        return response()->json($result, 200);
    }
}
