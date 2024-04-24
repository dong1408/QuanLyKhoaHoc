<?php

namespace App\Exceptions\Excel;

use App\Utilities\ResponseError;
use Exception;

class CannotReturnResultFileException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không thể trả về kết quả import"
            ),
            400
        );
    }
}