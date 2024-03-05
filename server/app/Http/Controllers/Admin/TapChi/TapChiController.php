<?php

namespace App\Http\Controllers\Admin\TapChi;

use App\Exceptions\Delete\DeleteFailException;
use App\Exceptions\TapChi\TapChiNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\TapChi\TapChi;
use App\Service\TapChi\TapChiService;
use App\Utilities\Convert;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class TapChiController extends Controller
{
    private TapChiService $tapChiService;

    public function __construct(TapChiService $tapChiService)
    {
        $this->tapChiService = $tapChiService;
        $this->middleware('auth:api');
    }


    public function getAllTapChi(): Response
    {
        $result =  $this->tapChiService->getAllTapChi();
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

    public function createTapChi(Request $request): Response
    {
        $result = $this->tapChiService->createTapChi($request);
        return response()->json($result, 200);
    }

    public function updateTrangThaiTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTrangThaiTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateKhongCongNhanTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateKhongCongNhanTapChi($request, $id);
        return response()->json($result);
    }

    public function updateXepHangTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateXepHangTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTinhDiemTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTinhDiemTapChi($request, $id);
        return response()->json($result, 200);
    }

    // public function deleteTapChi($id)
    // {
    //     $id_tapchi = (int) $id;
    //     $tapChi = TapChi::find($id_tapchi);
    //     if ($tapChi == null) {
    //         throw new TapChiNotFoundException();
    //     }
    //     if (!$tapChi->delete()) {
    //         throw new DeleteFailException();
    //     }
    //     return response()->json("Thành công", 200);
    // }

    // public function restoreTapChi($id)
    // {
    //     $id_tapchi = (int) $id;
    //     $tapChi = TapChi::find($id_tapchi);
    //     if ($tapChi == null) {
    //         throw new TapChiNotFoundException();
    //     }
    //     TapChi::onlyTrashed()->where('id', $id_tapchi)->restore();
    // }

    // public function forceDeleteTapChi($id)
    // {
    //     $id_tapchi = (int) $id;
    //     $tapChi = TapChi::find($id_tapchi);
    //     if ($tapChi == null) {
    //         throw new TapChiNotFoundException();
    //     }
    //     TapChi::onlyTrashed()->where('id', $id_tapchi)->forceDelete();
    // }
}
