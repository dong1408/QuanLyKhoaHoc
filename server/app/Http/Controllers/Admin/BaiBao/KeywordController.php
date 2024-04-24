<?php

namespace App\Http\Controllers\Admin\BaiBao;

use App\Http\Controllers\Controller;
use App\Service\BaiBao\KeywordService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KeywordController extends Controller
{
    private KeywordService $keywordService;
    public function __construct(KeywordService $keywordService)
    {
        $this->keywordService = $keywordService;
        $this->middleware('auth:api');
    }

    public function getAllKeyword(Request $request): Response
    {
        $result = $this->keywordService->getAllKeyword($request);
        return response()->json($result, 200);
    }
}
