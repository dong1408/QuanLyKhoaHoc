<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class DeTaiNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy đề tài"
            ),
            404
        );
    }
}
