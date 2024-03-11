<?php

namespace App\Http\Controllers\Admin\SanPham;


use App\Http\Controllers\Controller;
use App\Service\SanPham\DMSanPhamService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DMSanPhamController extends Controller
{
    private DMSanPhamService $dmSanPhamService;

    public function __construct(DMSanPhamService $dmSanPhamService)
    {
        $this->dmSanPhamService = $dmSanPhamService;
        $this->middleware('auth:api');
    }

    public function getDmSanPham(): Response
    {
        $result = $this->dmSanPhamService->getDmSanPham();
        return response()->json($result, 200);
    }
}
