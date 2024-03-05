<?php

namespace App\Exceptions\NhaXuatBan;

use App\Utilities\ResponseError;
use Exception;


class NhaXuatBanNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "NOT FOUND",
                404,
                "Không tìm thấy nhà xuất bản"
            ),
            404
        );
    }
}
