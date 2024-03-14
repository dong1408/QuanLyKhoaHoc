<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\ChuyenMonService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChuyenMonController extends Controller
{
    private ChuyenMonService $chuyenMonService;
    public function __construct(ChuyenMonService $chuyenMonService)
    {
        $this->chuyenMonService = $chuyenMonService;
        $this->middleware('auth:api');
    }

    public function getAllChuyenMon(): Response
    {
        $result = $this->chuyenMonService->getAllChuyenMon();
        return response()->json($result, 200);
    }
}
