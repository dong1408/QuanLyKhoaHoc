<?php

namespace App\Service\BaiBao;

use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateSanPhamRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface BaiBaoService
{
    public function getDMSanPham();
    public function getBaiBaoPaging(Request $request): ResponseSuccess;
    public function getBaiBaoChoDuyet(Request $request): ResponseSuccess;
    public function getDetailBaiBao(int $id): ResponseSuccess;
    public function createBaiBao(CreateBaiBaoRequest $request): ResponseSuccess;
    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess;
    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateBaiBaoDong(CreateBaiBaoRequest $request, int $id);
    public function deleteBaiBao(int $id): ResponseSuccess;
    public function restoreBaiBao(int $id): ResponseSuccess;
    public function forceDeleteBaiBao(int $id): ResponseSuccess;
}
