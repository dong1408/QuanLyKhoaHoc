<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\NgachVienChucService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NgachVienChucController extends Controller
{
    private NgachVienChucService $ngachVienChucService;
    public function __construct(NgachVienChucService $ngachVienChucService)
    {
        $this->ngachVienChucService = $ngachVienChucService;
        $this->middleware('auth:api');
    }

    public function getAllNgachVienChuc(): Response
    {
        $result = $this->ngachVienChucService->getAllNgachVienChuc();
        return response()->json($result, 200);
    }
}
