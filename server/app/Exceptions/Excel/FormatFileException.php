<?php

namespace App\Exceptions\Excel;

use App\Utilities\ResponseError;
use Exception;


class FormatFileException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "File import không đúng format"
            ),
            404
        );
    }
}
