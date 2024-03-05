<?php

namespace App\Exceptions\Delete;

use App\Utilities\ResponseError;
use Exception;


class DeleteFailException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Xóa không thành công"
            ),
            404
        );
    }
}
