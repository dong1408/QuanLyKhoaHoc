<?php

namespace App\Http\Controllers\Admin\TapChi;

use App\Http\Controllers\Controller;
use App\Service\TapChi\PhanLoaiTapChiService;
use Symfony\Component\HttpFoundation\Response;


class PhanLoaiTapChiController extends Controller
{
    private PhanLoaiTapChiService $phanLoaiTapChiService;

    public function __construct(PhanLoaiTapChiService $phanLoaiTapChiService)
    {
        $this->phanLoaiTapChiService = $phanLoaiTapChiService;
        $this->middleware('auth:api', ['except' => ['test']]);
    }


    public function getPhanLoaiTapChiByIdTapChi($id): Response
    {
        $result = $this->phanLoaiTapChiService->getPhanLoaiByTapChiId($id);
        return response()->json($result, 200);
    }

    public function getAllPhanLoaiTapChi():Response
    {
        $result = $this->phanLoaiTapChiService->getAllPhanLoaiTapChi();
        return response()->json($result, 200);
    }
}
