<?php

namespace App\Http\Controllers\Admin\TapChi;

use App\Http\Controllers\Controller;
use App\Http\Requests\TapChi\CreateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTapChiKhongCongNhanRequest;
use App\Http\Requests\TapChi\UpdateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTinhDiemTapChiRequest;
use App\Http\Requests\TapChi\UpdateTrangThaiTapChiRequest;
use App\Http\Requests\TapChi\UpdateXepHangTapChiRequest;
use App\Service\TapChi\PhanLoaiTapChiService;
use App\Service\TapChi\TapChiService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TapChiController extends Controller
{
    private TapChiService $tapChiService;

    public function __construct(TapChiService $tapChiService)
    {
        $this->tapChiService = $tapChiService;
        $this->middleware('auth:api', ['except' => ['test']]);
    }


    public function getAllTapChi(Request $request): Response
    {
        $result =  $this->tapChiService->getAllTapChi($request);
        return response()->json($result, 200);
    }

    public function getAllTapChiChoDuyet(Request $request): Response
    {
        $result =  $this->tapChiService->getAllTapChiChoDuyet($request);
        return response()->json($result, 200);
    }

    public function getTapChiPaging(Request $request): Response
    {
        $result =  $this->tapChiService->getTapChiPaging($request);
        return response()->json($result, 200);
    }

    public function getTapChiById($id): Response
    {
        $result = $this->tapChiService->getTapChiById($id);
        return response()->json($result, 200);
    }

    public function getDetailTapChi($id)
    {
        $result = $this->tapChiService->getDetailTapChi($id);
        return response()->json($result, 200);
    }

    public function getLichSuTapChiKhongCongNhan(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuTapChiKhongCongNhan($request, $id);
        return response()->json($result, 200);
    }

    public function getLichSuXepHangTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuXepHangTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function getLichSuTinhDiemTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuTinhDiemTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function createTapChi(CreateTapChiRequest $request): Response
    {
        $result = $this->tapChiService->createTapChi($request);
        return response()->json($result, 200);
    }

    public function updateTrangThaiTapChi(UpdateTrangThaiTapChiRequest $request, $id): Response
    {
        $result = $this->tapChiService->updateTrangThaiTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTapChi(UpdateTapChiRequest $request, $id)
    {
        $result = $this->tapChiService->updateTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateKhongCongNhanTapChi(UpdateTapChiKhongCongNhanRequest $request, $id): Response
    {
        $result = $this->tapChiService->updateKhongCongNhanTapChi($request, $id);
        return response()->json($result);
    }

    public function updateXepHangTapChi(UpdateXepHangTapChiRequest $request, $id): Response
    {
        $result = $this->tapChiService->updateXepHangTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTinhDiemTapChi(UpdateTinhDiemTapChiRequest $request, $id): Response
    {
        $result = $this->tapChiService->updateTinhDiemTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function deleteTapChi($id)
    {
        $result = $this->tapChiService->deleteTapChi($id);
        return response()->json($result, 200);
    }

    public function restoreTapChi($id)
    {
        $result = $this->tapChiService->restoreTapChi($id);
        return response()->json($result, 200);
    }

    public function forceDeleteTapChi($id)
    {
        $result = $this->tapChiService->forceDeleteTapChi($id);
        return response()->json($result, 200);
    }
}
