<?php

namespace App\Service\TapChi;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface TapChiService
{
    public function getAllTapChi(): ResponseSuccess;
    public function getTapChiPaging(Request $request): ResponseSuccess;
    public function getTapChiById(int $id): ResponseSuccess;
    public function getDetailTapChi(int $id);
    public function getLichSuTapChiKhongCongNhan(Request $request, int $id): ResponseSuccess;
    public function getLichSuXepHangTapChi(Request $request, int $id): ResponseSuccess;
    public function getLichSuTinhDiemTapChi(Request $request, int $id): ResponseSuccess;
    public function createTapChi(Request $request): ResponseSuccess;
    public function updateTrangThaiTapChi(Request $request, int $id): ResponseSuccess;
    public function updateTapChi(Request $request, int $id): ResponseSuccess;
    public function updateKhongCongNhanTapChi(Request $request, int $id): ResponseSuccess;
    public function updateXepHangTapChi(Request $request, int $id): ResponseSuccess;
    public function updateTinhDiemTapChi(Request $request, int $id): ResponseSuccess;
    // public function deleteTapChi();
}
