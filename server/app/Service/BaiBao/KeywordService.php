<?php

namespace App\Service\BaiBao;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface KeywordService
{
    public function getAllKeyword(Request $request): ResponseSuccess;
    public function keKhaiKeyword();
}
