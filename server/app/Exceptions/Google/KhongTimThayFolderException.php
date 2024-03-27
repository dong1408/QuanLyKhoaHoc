<?php

namespace App\Exceptions\Google;

use App\Utilities\ResponseError;
use Exception;

class KhongTimThayFolderException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy thư mục lưu trữ"
            ),
            404
        );
    }
}