<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\PhanLoaiToChucService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PhanLoaiToChucController extends Controller
{
    private PhanLoaiToChucService $phanLoaiToChucService;
    public function __construct(PhanLoaiToChucService $phanLoaiToChucService)
    {
        $this->phanLoaiToChucService = $phanLoaiToChucService;
        $this->middleware('auth:api');
    }

    public function getAllPhanLoaiToChuc(): Response
    {
        $result = $this->phanLoaiToChucService->getAllPhanLoaiToChuc();
        return response()->json($result, 200);
    }
}
