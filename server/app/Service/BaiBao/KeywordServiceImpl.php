<?php

namespace App\Service\BaiBao;

use App\Models\BaiBao\Keyword;
use App\Utilities\Convert;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

class KeywordServiceImpl implements KeywordService
{
    public function getAllKeyword(Request $request): ResponseSuccess
    {
        $keysearch = $request->query('search', "");
        $result = [];
        if (!empty($keysearch)) {
            $keywords = Keyword::where('name', 'LIKE', '%' . $keysearch . '%')->take(10)->get();
            foreach ($keywords as $keyword) {
                $result[] = Convert::getKeywordVm($keyword);
            }
        }
        return new ResponseSuccess("Thành công", $result);
    }


    public function themKeywordNgoai($array): Keyword
    {
        $keyword = Keyword::create([
            'name' => $array['name']
        ]);
        return $keyword;
    }
}
