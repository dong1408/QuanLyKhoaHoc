<?php

namespace App\Service\DeTai;

use App\Http\Requests\DeTai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\DeTai\CreateDeTaiRequest;
use App\Http\Requests\DeTai\NghiemThuDeTaiRequest;
use App\Http\Requests\DeTai\TuyenChonDeTaiRequest;
use App\Http\Requests\DeTai\UpdateDeTaiForUserRequest;
use App\Http\Requests\DeTai\UpdateDeTaiRequest;
use App\Http\Requests\DeTai\XetDuyetDeTaiRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Http\Requests\SanPham\UploadFileMinhChungRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface DeTaiService
{
    public function getDeTaiPaging(Request $request): ResponseSuccess;
    public function getDeTaiPagingForUser(Request $request): ResponseSuccess;
    public function getDeTaiChoDuyet(Request $request): ResponseSuccess;
    public function getDetailDeTai(int $id): ResponseSuccess;
    public function getDetailDeTaiForUser(int $id): ResponseSuccess;
    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess;
    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateDeTai(UpdateDeTaiRequest $request, int $id): ResponseSuccess;
    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess;
    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateTrangThaiRaSoatDeTai(UpdateTrangThaiRaSoatRequest $request, int $id): ResponseSuccess;
    public function tuyenChonDeTai(TuyenChonDeTaiRequest $request, int $id): ResponseSuccess;
    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request, int $id): ResponseSuccess;
    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request, int $id): ResponseSuccess;
    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request, int $id): ResponseSuccess;
    public function getLichSuBaoCao(Request $request, int $id): ResponseSuccess;
    public function deleteDeTai(int $id): ResponseSuccess;
    public function restoreDeTai(int $id): ResponseSuccess;
    public function forceDeleteDeTai(int $id): ResponseSuccess;
    public function getDeTaiKeKhai(Request $request): ResponseSuccess;
    public function getDeTaiThamGia(Request $request): ResponseSuccess;
    public function updateDeTaiForUser(UpdateDeTaiForUserRequest $request, int $id): ResponseSuccess;
    public function UploadFileMinhChung(UploadFileMinhChungRequest $request):ResponseSuccess;
}
