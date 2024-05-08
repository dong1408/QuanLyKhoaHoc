<?php

namespace App\Http\Controllers\Admin\DeTai;

use App\Http\Controllers\Controller;
use App\Service\DeTai\PhanLoaiDeTaiService;
use Illuminate\Http\Request;

class PhanLoaiDeTaiController extends Controller
{
    private PhanLoaiDeTaiService $phanLoaiDetaiService;

    public function __construct(PhanLoaiDeTaiService $phanLoaiDetaiService)
    {
        $this->phanLoaiDetaiService = $phanLoaiDetaiService;
    }

    public function getPhanLoaiDeTai()
    {
        $result = $this->phanLoaiDetaiService->getPhanLoaiDeTai();
        return response()->json($result, 200);
    }
}
