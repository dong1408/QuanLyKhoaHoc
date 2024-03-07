<?php

namespace App\Service\BaiBao;

use App\Http\Requests\BaiBao\CreateBaiBaoRequest;
use Illuminate\Http\Request;

interface BaiBaoService
{
    public function getDMSanPham();
    public function getBaiBaoPaging(Request $request);
    public function getBaiBaoChoDuyet(Request $request);
    public function getDetailBaiBao(int $id);
    public function createBaiBao(CreateBaiBaoRequest $request);
    public function updateBaiBao();
    public function deleteBaiBao(int $id);
    public function restoreBaiBao(int $id);
    public function forceDeleteBaiBao(int $id);
}
