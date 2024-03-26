<?php

namespace App\Exceptions\BaiBao;

use App\Utilities\ResponseError;
use Exception;


class RoleOnlyHeldByOnePersonException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Vai trò tác giả đứng đầu hoặc vai trò tác giả liên hệ chỉ một người được đảm nhiệm"
            ),
            400
        );
    }
}
