<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class FileMinhChungNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy file minh chứng"
            ),
            404
        );
    }
}
