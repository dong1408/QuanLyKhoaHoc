<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class RoleOnlyHeldByOnePersonInDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Vai trò chủ nhiệm đề tài chỉ một người được đảm nhiệm"
            ),
            400
        );
    }
}
