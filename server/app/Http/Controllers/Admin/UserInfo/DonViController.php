<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Service\UserInfo\DonViService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DonViController extends Controller
{
    private DonViService $donViService;

    public function __construct(DonViService $donViService)
    {
        $this->donViService = $donViService;
        $this->middleware('auth:api');
    }

    public function getAllDonVi(): Response
    {
        $result = $this->donViService->getAllDonVi();
        return response()->json($result, 200);
    }

    public function getDonViByToChucId(int $id): Response
    {
        $result = $this->donViService->getDonViByIdToChuc($id);
        return response()->json($result, 200);
    }
}
