<?php

namespace App\Http\Controllers\Admin\QuyDoi;

use App\Http\Controllers\Controller;
use App\Service\QuyDoi\ChuyenNganhTinhDiemService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChuyenNganhTinhDiemController extends Controller
{
    private ChuyenNganhTinhDiemService $chuyenNganhTinhDiemService;
    public function __construct(ChuyenNganhTinhDiemService $chuyenNganhTinhDiemService)
    {
        $this->chuyenNganhTinhDiemService = $chuyenNganhTinhDiemService;
    }

    public function getAllChuyenNganhTinhDiem(): Response{
        $result = $this->chuyenNganhTinhDiemService->getAllChuyenNganhTinhDiem();
        return response()->json($result, 200);
    }

    public function getChuyeNganhTinhDiemByIdNganhTinhDiem(int $id): Response{
        $result = $this->chuyenNganhTinhDiemService->getChuyeNganhTinhDiemByIdNganhTinhDiem($id);
        return response()->json($result, 200);
    }
}
