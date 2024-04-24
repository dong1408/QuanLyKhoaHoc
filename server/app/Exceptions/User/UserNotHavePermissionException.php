<?php

namespace App\Exceptions\User;

use App\Custom\StatusText;
use App\Utilities\ResponseError;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserNotHavePermissionException extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "FORBIDEN",
                403,
                "Bạn không có quyền thực hiện thao tác này"
            ),
            403
        );
    }
}
