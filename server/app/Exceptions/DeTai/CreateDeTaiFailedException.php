<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class CreateDeTaiFailedException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không tìm thấy danh mục sản phẩm của đề tài"
            ),
            400
        );
    }
}
