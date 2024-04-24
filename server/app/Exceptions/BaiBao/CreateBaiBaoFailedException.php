<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class CreateBaiBaoFailedException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Không tìm thấy danh mục sản phẩm của bài báo"
            ),
            400
        );
    }
}
