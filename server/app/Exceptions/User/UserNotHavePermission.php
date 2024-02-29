<?php

namespace App\Exceptions\User;

use App\Custom\StatusText;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserNotHavePermission extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return response()->json([
            'status' => StatusText::_statustext(Response::HTTP_FORBIDDEN),
            'message' => 'User not have permission'
        ], 403)->header('Content-Type', 'application/json');
    }
}
