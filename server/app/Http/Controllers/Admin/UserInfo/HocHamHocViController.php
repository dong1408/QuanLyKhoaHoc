<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\HocHamHocViService;
use App\Service\UserInfo\QuocGiaService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HocHamHocViController extends Controller
{
    private HocHamHocViService $hocHamHocViService;

    public function __construct(HocHamHocViService $hocHamHocViService)
    {
        $this->hocHamHocViService = $hocHamHocViService;
        $this->middleware('auth:api');
    }

    public function getAllHocHamHocVi(): Response
    {
        $result = $this->hocHamHocViService->getAllHocHamHocVi();
        return response()->json($result, 200);
    }
}
