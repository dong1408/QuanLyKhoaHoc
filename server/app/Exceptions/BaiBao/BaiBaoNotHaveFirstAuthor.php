<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class BaiBaoNotHaveFirstAuthor extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Bài báo phải có ít nhất 1 tác giả đảm nhiệm vai trò tác giả đầu tiên"
            ),
            404
        );
    }
}
