<?php

namespace App\Exceptions\DeTai;

use App\Utilities\ResponseError;
use Exception;


class TwoRoleSimilarForOnePersonInDeTaiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Một người không thể có 2 vai trò giống nhau trong cùng một đề tài"
            ),
            400
        );
    }
}
