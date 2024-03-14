<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\QuocGiaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HocHamHocViCOntroller extends Controller
{
    private QuocGiaService $quocGiaService;

    public function __construct(QuocGiaService $quocGiaService)
    {
        $this->quocGiaService = $quocGiaService;
        $this->middleware('auth:api');
    }

    public function getAllQuocGia(): Response
    {
        $result = $this->quocGiaService->getAllQuocGia();
        return response()->json($result, 200);
    }
}
