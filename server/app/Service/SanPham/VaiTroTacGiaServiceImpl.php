<?php
namespace App\Service\SanPham;

use App\Models\SanPham\DMVaiTroTacGia;
use App\Service\SanPham\VaiTroTacGiaService;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;

class VaiTroTacGiaServiceImpl implements VaiTroTacGiaService
{
    public function getVaiTroOfBaiBao(): ResponseSuccess
    {
        $vaiTros = DMVaiTroTacGia::where('role', 'baibao')->get(); // sản phẩm
        $result = [];
        foreach ($vaiTros as $vaiTro) {
            $result[] = Convert::getVaiTroTacGiaVm($vaiTro);
        }
        return new ResponseSuccess("Thành công", $result);
    }

    public function getVaiTroOfDeTai(): ResponseSuccess
    {
        $vaiTros = DMVaiTroTacGia::where('role', 'detai')->get();
        $result = [];
        foreach ($vaiTros as $vaiTro) {
            $result[] = Convert::getVaiTroTacGiaVm($vaiTro);
        }
        return new ResponseSuccess("Thành công", $result);
    }
}
