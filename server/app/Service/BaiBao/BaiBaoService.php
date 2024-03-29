<?php

namespace App\Service\BaiBao;

use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoForUserRequest;
use App\Http\Requests\BaiBao\UpdateBaiBaoRequest;
use App\Http\Requests\SanPham\UpdateFileMinhChungSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamRequest;
use App\Http\Requests\SanPham\UpdateSanPhamTacGiaRequest;
use App\Http\Requests\SanPham\UpdateTrangThaiRaSoatRequest;
use App\Http\Requests\SanPham\UploadFileMinhChungRequest;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface BaiBaoService
{
    public function getBaiBaoPaging(Request $request): ResponseSuccess;
    public function getBaiBaoPagingForUser(Request $request): ResponseSuccess;
    public function getBaiBaoChoDuyet(Request $request): ResponseSuccess;
    public function getDetailBaiBao(int $id): ResponseSuccess;
    public function getDetailBaiBaoForUser(int $id): ResponseSuccess;
    public function createBaiBao(CreateBaiBaoRequest $request): ResponseSuccess;
    public function updateSanPham(UpdateSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateBaiBao(UpdateBaiBaoRequest $request, int $id): ResponseSuccess;
    public function updateSanPhamTacGia(UpdateSanPhamTacGiaRequest $request, int $id): ResponseSuccess;
    public function updateFileMinhChung(UpdateFileMinhChungSanPhamRequest $request, int $id): ResponseSuccess;
    public function updateTrangThaiRaSoatBaiBao(UpdateTrangThaiRaSoatRequest $request, int $id): ResponseSuccess;
    public function deleteBaiBao(int $id): ResponseSuccess;
    public function restoreBaiBao(int $id): ResponseSuccess;
    public function forceDeleteBaiBao(int $id): ResponseSuccess;
    public function getBaiBaoKeKhai(Request $request): ResponseSuccess;
    public function getBaiBaoThamGia(Request $request): ResponseSuccess;
    public function updateBaiBaoForUser(UpdateBaiBaoForUserRequest $request, int $id): ResponseSuccess;
    public function UploadFileMinhChung(UploadFileMinhChungRequest $request):ResponseSuccess;
}
