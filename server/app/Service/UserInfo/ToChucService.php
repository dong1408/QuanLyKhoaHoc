<?php

namespace App\Service\UserInfo;

use App\Models\UserInfo\DMToChuc;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface ToChucService
{
    public function getAllToChuc(Request $request): ResponseSuccess;
    public function themToChucNgoai($array): DMToChuc;
}
