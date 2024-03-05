<?php

namespace App\Exceptions;

use App\Utilities\ResponseError;
use Exception;

class InvalidValueException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD_REQUEST",
                400,
                "Giá trị không hợp lệ"
            ),
            400
        );
    }
}
