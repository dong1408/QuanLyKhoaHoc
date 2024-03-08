<?php

namespace App\Service\TapChi;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface TheoHDGSService
{
    public function getAllHDGS(): ResponseSuccess;
}
