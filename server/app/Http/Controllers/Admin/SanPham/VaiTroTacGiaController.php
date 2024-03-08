<?php

namespace App\Http\Controllers\Admin\SanPham;

use App\Http\Controllers\Controller;
use App\Service\SanPham\VaiTroTacGiaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VaiTroTacGiaController extends Controller
{
    private VaiTroTacGiaService $vaiTroTacGiaService;

    public function __construct(VaiTroTacGiaService $vaiTroTacGiaService)
    {
        $this->vaiTroTacGiaService = $vaiTroTacGiaService;
        $this->middleware('auth:api');
    }

    public function getVaiTroOfBaiBao(): Response
    {
        $result =  $this->vaiTroTacGiaService->getVaiTroOfBaiBao();
        return response()->json($result, 200);
    }

    public function getVaiTroOfDeTai(): Response
    {
        $result =  $this->vaiTroTacGiaService->getVaiTroOfDeTai();
        return response()->json($result, 200);
    }
}
