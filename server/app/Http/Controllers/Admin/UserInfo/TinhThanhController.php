<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\TinhThanhService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TinhThanhController extends Controller
{
    private TinhThanhService $tinhThanhService;
    public function __construct(TinhThanhService $tinhThanhService)
    {
        $this->tinhThanhService = $tinhThanhService;
        $this->middleware('auth:api');
    }

    public function getAllTinhThanh(): Response
    {
        $result = $this->tinhThanhService->getAllTinhThanh();
        return response()->json($result, 200);
    }

    public function getAllTinhThanhByIdQuocGia($id){
        $result = $this->tinhThanhService->getAllTinhThanhByIdQuocGia($id);
        return response()->json($result, 200);
    }
}
