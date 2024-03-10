<?php

namespace App\Service\DeTai;

use App\Http\Requests\Detai\CreateDeTaiRequest;
use App\Utilities\ResponseSuccess;


interface DeTaiService
{
    public function getDeTaiPaging(): ResponseSuccess;
    public function createDeTai(CreateDeTaiRequest $request): ResponseSuccess;
    public function updateDeTai(): ResponseSuccess;
    public function updateSanPham(): ResponseSuccess;
    public function updateVaiTroTacGia(): ResponseSuccess;
    public function tuyenChonDeTai(): ResponseSuccess;
    public function xetDuyetDeTai(): ResponseSuccess;
    public function baoCaoTienDoDeTai(): ResponseSuccess;
    public function nghiemThuDeTai(): ResponseSuccess;
    public function getPhanLoaiDeTai(): ResponseSuccess;
}
