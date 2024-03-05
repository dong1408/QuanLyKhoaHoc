<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class NganhTheoHDGSNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy phân loại ngành theo hội đồng giáo sư"
            ),
            404
        );
    }
}
