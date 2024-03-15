<?php

namespace App\Exceptions\User;

use App\Utilities\ResponseError;
use Exception;
use Illuminate\Http\Request;
use Throwable;

class  PasswordIncorrectException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                "Password không đúng"
            ),
            400
        );
    }
}
