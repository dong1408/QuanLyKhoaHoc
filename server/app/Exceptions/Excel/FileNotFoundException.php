<?php

namespace App\Exceptions\Excel;

use App\Utilities\ResponseError;
use Exception;


class FileNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không tìm thấy file"
            ),
            404
        );
    }
}
