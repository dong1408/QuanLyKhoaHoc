<?php

namespace App\Service\BaiBao;

use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\BaiBao\UpdateTrangThaiRaSoatBaiBao;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface BaiBaoService
{
    public function getBaiBaoPaging(Request $request): ResponseSuccess;
    public function getBaiBaoChoDuyet(Request $request): ResponseSuccess;
    public function getDetailBaiBao(int $id): ResponseSuccess;
    public function createBaiBao(CreateBaiBaoRequest $request): ResponseSuccess;
    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess;
    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess;
    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatBaiBao $request, int $id): ResponseSuccess;
    public function deleteBaiBao(int $id): ResponseSuccess;
    public function restoreBaiBao(int $id): ResponseSuccess;
    public function forceDeleteBaiBao(int $id): ResponseSuccess;
}
