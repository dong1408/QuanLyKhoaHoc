<?php

namespace App\Service\DeTai;

use App\Http\Requests\Detai\BaoCaoTienDoDeTaiRequest;
use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Http\Requests\Detai\NghiemThuDeTaiRequest;
use App\Http\Requests\Detai\TuyenChonDeTaiRequest;
use App\Http\Requests\Detai\UpdateDeTaiRequest;
use App\Http\Requests\Detai\XetDuyetDeTaiRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Utilities\ResponseSuccess;


interface DeTaiService
{
    public function getDeTaiPaging(): ResponseSuccess;
    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess;
    public function updateDeTai(UpdateDeTaiRequest $request, int $id): ResponseSuccess;
    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess;
    public function tuyenChonDeTai(TuyenChonDeTaiRequest $request, int $id): ResponseSuccess;
    public function xetDuyetDeTai(XetDuyetDeTaiRequest $request, int $id): ResponseSuccess;
    public function baoCaoTienDoDeTai(BaoCaoTienDoDeTaiRequest $request, int $id): ResponseSuccess;
    public function nghiemThuDeTai(NghiemThuDeTaiRequest $request, int $id): ResponseSuccess;
    public function getPhanLoaiDeTai(): ResponseSuccess;
}
