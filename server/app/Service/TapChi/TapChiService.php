<?php

namespace App\Service\TapChi;

use App\Http\Requests\TapChi\CreateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTapChiKhongCongNhanRequest;
use App\Http\Requests\TapChi\UpdateTapChiRequest;
use App\Http\Requests\TapChi\UpdateTinhDiemTapChiRequest;
use App\Http\Requests\TapChi\UpdateTrangThaiTapChiRequest;
use App\Http\Requests\TapChi\UpdateXepHangTapChiRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface TapChiService
{
    public function getAllTapChi(Request $request): ResponseSuccess;
    public function getTapChiPaging(Request $request): ResponseSuccess;
    public function getAllTapChiChoDuyet(Request $request): ResponseSuccess;
    public function getTapChiById(int $id): ResponseSuccess;
    public function getDetailTapChi(int $id);
    public function getLichSuTapChiKhongCongNhan(Request $request, int $id): ResponseSuccess;
    public function getLichSuXepHangTapChi(Request $request, int $id): ResponseSuccess;
    public function getLichSuTinhDiemTapChi(Request $request, int $id): ResponseSuccess;

    public function createTapChi(CreateTapChiRequest $request): ResponseSuccess;

    public function updateTrangThaiTapChi(UpdateTrangThaiTapChiRequest $request, int $id): ResponseSuccess;
    public function updateTapChi(UpdateTapChiRequest $request, int $id): ResponseSuccess;
    public function updateKhongCongNhanTapChi(UpdateTapChiKhongCongNhanRequest $request, int $id): ResponseSuccess;
    public function updateXepHangTapChi(UpdateXepHangTapChiRequest $request, int $id): ResponseSuccess;
    public function updateTinhDiemTapChi(UpdateTinhDiemTapChiRequest $request, int $id): ResponseSuccess;

    public function deleteTapChi(int $id): ResponseSuccess;
    public function restoreTapChi(int $id): ResponseSuccess;
    public function forceDeleteTapChi(int $id): ResponseSuccess;
}
