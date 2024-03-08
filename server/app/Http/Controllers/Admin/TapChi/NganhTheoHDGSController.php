<?php

namespace App\Http\Controllers\Admin\TapChi;

use App\Http\Controllers\Controller;
use App\Service\TapChi\PhanLoaiTapChiService;
use App\Service\TapChi\TheoHDGSService;
use Symfony\Component\HttpFoundation\Response;


class NganhTheoHDGSController extends Controller
{
    private TheoHDGSService $theoHDGSService;

    public function __construct(TheoHDGSService $theoHDGSService)
    {
        $this->theoHDGSService = $theoHDGSService;
        $this->middleware('auth:api', ['except' => ['test']]);
    }

    public function getAllHDGS():Response
    {
        $result = $this->theoHDGSService->getAllHDGS();
        return response()->json($result, 200);
    }
}
