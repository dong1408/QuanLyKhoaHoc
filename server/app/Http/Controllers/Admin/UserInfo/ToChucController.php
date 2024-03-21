<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\QuocGiaService;
use App\Service\UserInfo\ToChucService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ToChucController extends Controller
{
    private ToChucService $toChucService;
    public function __construct(ToChucService $toChucService)
    {
        $this->toChucService = $toChucService;
        $this->middleware('auth:api');
    }

    public function getAllToChuc(Request $request): Response
    {
        $result = $this->toChucService->getAllToChuc($request);
        return response()->json($result, 200);
    }
}
