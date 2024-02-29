<?php

namespace App\Exceptions\User;

use App\Custom\StatusText;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Throwable;

class UserNotFound extends Exception
{
    public function report()
    {
    }

    public function render($request)
    {
        return response()->json([
            'status' => StatusText::_statustext(Response::HTTP_NOT_FOUND),
            'message' => 'user not found'
        ], Response::HTTP_NOT_FOUND)->header('Content-Type', 'application/json');
    }
}
