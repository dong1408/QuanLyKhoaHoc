<?php

namespace App\Service\TapChi;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface PhanLoaiTapChiService
{
    public function getPhanLoaiByTapChiId(int $id_tapchi): ResponseSuccess;        
}
