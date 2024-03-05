<?php

namespace App\Http\Controllers\Admin\QuyDoi;

use App\Http\Controllers\Controller;
use App\Service\QuyDoi\NganhTinhDiemService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NganhTinhDiemController extends Controller
{
    private NganhTinhDiemService $nganhTinhDiemService;
    public function __construct(NganhTinhDiemService $nganhTinhDiemService)
    {
        $this->nganhTinhDiemService = $nganhTinhDiemService;
    }

    public function getAllNganhTinhDiem(): Response
    {
        $result[] = $this->nganhTinhDiemService->getAllNganhTinhDiem();
        return response()->json($result, 200);
    }
}
