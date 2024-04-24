<?php

namespace App\Exceptions\Excel;

use App\Utilities\ResponseError;
use Exception;


class ValidateFileException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "File import phải là file excel"
            ),
            404
        );
    }
}
