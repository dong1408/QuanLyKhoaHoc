<?php

namespace App\Service\BaiBao;

use App\Models\BaiBao\Keyword;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface KeywordService
{
    public function getAllKeyword(Request $request): ResponseSuccess;
    public function themKeywordNgoai($array):Keyword;
}
