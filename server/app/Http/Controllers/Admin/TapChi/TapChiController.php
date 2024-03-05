<?php

namespace App\Http\Controllers\Admin\TapChi;

use App\Http\Controllers\Controller;
use App\Models\TapChi\TapChi;
use App\Service\TapChi\PhanLoaiTapChiService;
use App\Service\TapChi\TapChiService;
use App\Utilities\Convert;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class TapChiController extends Controller
{
    private TapChiService $tapChiService;
    private PhanLoaiTapChiService $phanLoaiTapChiService;

    public function __construct(TapChiService $tapChiService, PhanLoaiTapChiService $phanLoaiTapChiService)
    {
        $this->tapChiService = $tapChiService;
        $this->phanLoaiTapChiService = $phanLoaiTapChiService;
        $this->middleware('auth:api', ['except' => ['test']]);
    }


    public function test()
    {
        $a = "abc";
        // $sql = User::where([['name', 'LIKE', '%a%'], ['username', 'LIKE', '%ô%']])->toSql();

        // $sql = DB::table('users')
        //     ->where('role', 1)
        //     ->orWhere(function (Builder $query) {
        //         $query->where('name', 'abc')
        //             ->where('username', 'abc');
        //     })->toSql();

        // $sql = User::where([['name', 'abc'], ['username', 'xyz']])->orWhere('role', '1')->toSql();

        $sql = TapChi::onlyTrashed()->where(function ($query) {
            $query->where('name', 'a')
                ->orWhere('issn', 'LIKE', 'b');
        })->where(function ($query) {
            $query->where('trangthai', true);
        })->toSql();
        return response()->json($sql, 200);
    }

    public function getPhanLoaiTapChiByIdTapChi($id): Response
    {
        $result = $this->phanLoaiTapChiService->getPhanLoaiByTapChiId($id);
        return response()->json($result, 200);
    }

    public function getAllTapChi(): Response
    {
        $result =  $this->tapChiService->getAllTapChi();
        return response()->json($result, 200);
    }

    public function getTapChiPaging(Request $request): Response
    {
        $result =  $this->tapChiService->getTapChiPaging($request);
        return response()->json($result, 200);
    }

    public function getTapChiById($id): Response
    {
        $result = $this->tapChiService->getTapChiById($id);
        return response()->json($result, 200);
    }

    public function getDetailTapChi($id)
    {
        $result = $this->tapChiService->getDetailTapChi($id);
        return response()->json($result, 200);
    }

    public function getLichSuTapChiKhongCongNhan(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuTapChiKhongCongNhan($request, $id);
        return response()->json($result, 200);
    }

    public function getLichSuXepHangTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuXepHangTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function getLichSuTinhDiemTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->getLichSuTinhDiemTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function createTapChi(Request $request): Response
    {
        $result = $this->tapChiService->createTapChi($request);
        return response()->json($result, 200);
    }

    public function updateTrangThaiTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTrangThaiTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateKhongCongNhanTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateKhongCongNhanTapChi($request, $id);
        return response()->json($result);
    }

    public function updateXepHangTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateXepHangTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function updateTinhDiemTapChi(Request $request, $id): Response
    {
        $result = $this->tapChiService->updateTinhDiemTapChi($request, $id);
        return response()->json($result, 200);
    }

    public function deleteTapChi($id)
    {
        $result = $this->tapChiService->deleteTapChi($id);
        return response()->json($result, 200);
    }

    public function restoreTapChi($id)
    {
        $result = $this->tapChiService->restoreTapChi($id);
        return response()->json($result, 200);
    }

    public function forceDeleteTapChi($id)
    {
        $result = $this->tapChiService->forceDeleteTapChi($id);
        return response()->json($result, 200);
    }
}
