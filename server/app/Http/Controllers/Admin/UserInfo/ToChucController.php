<?php

namespace App\Http\Controllers\Admin\UserInfo;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserInfo\ToChuc\CreateToChucRequest;
use App\Http\Requests\UserInfo\ToChuc\UpdateToChucRequest;
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

    public function getToChucPaging(Request $request): response
    {
        $result = $this->toChucService->getToChucPaging($request);
        return response()->json($result, 200);
    }


    public function getDetailToChuc(int $id): response
    {
        $result = $this->toChucService->getDetailToChuc($id);
        return response()->json($result, 200);
    }



    public function createToChuc(CreateToChucRequest $request): response
    {
        $result = $this->toChucService->createToChuc($request);
        return response()->json($result, 200);
    }

    public function updateToChuc(UpdateToChucRequest $request, int $id): response
    {
        $result = $this->toChucService->updateToChuc($request, $id);
        return response()->json($result, 200);
    }

    public function deleteToChuc(int $id): response
    {
        $result = $this->toChucService->deleteToChuc($id);
        return response()->json($result, 200);
    }
}
