<?php

namespace App\Http\Controllers\Admin\NhaXuatBan;

use App\Http\Controllers\Controller;
use App\Service\NhaXuatBan\NhaXuatBanService;
use App\Service\UserInfo\QuocGiaService;
use App\Service\UserInfo\ToChucService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NhaXuatBanController extends Controller
{
    private NhaXuatBanService $nhaXuatBanService;
    public function __construct(NhaXuatBanService $nhaXuatBanService)
    {
        $this->nhaXuatBanService = $nhaXuatBanService;
        $this->middleware('auth:api');
    }

    public function getAllNhaXuatBan(): Response
    {
        $result = $this->nhaXuatBanService->getAllNhaXuatBan();
        return response()->json($result, 200);
    }
}
