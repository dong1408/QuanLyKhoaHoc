<?php

namespace App\Exceptions;

use App\Exceptions\User\UserNotFound;
use App\Utilities\ResponseError;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        // $this->renderable(function (UserNotFound $e, Request $request) {
        //     return response()->json(new ResponseError("NOT_FOUND","404",$e->getMessage()),404);
        // });
        //test coi 
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {

        // User khong co quyen truy cap
        if ($exception instanceof \Illuminate\Auth\Access\AuthorizationException) {
            return response()->json(new ResponseError("Forbidden", 403, "Người dùng không có quyền truy cập"));
        }


        // method khong ho tro
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException) {
            return response()->json(new ResponseError("Method Not Allowed", 405, "Phương thức không được hỗ trợ"), 405);
        }


        // route khong duoc dinh nghia
        if ($exception instanceof \Symfony\Component\Routing\Exception\RouteNotFoundException) {
            return response()->json(new ResponseError("NOT FOUND", 404, "Đường dẫn không tồn tại trên hệ thống"), 404);
        }

        // route could not be found
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException) {
            return response()->json(new ResponseError("Not Found", 404, "Đường dẫn không tồn tại trên hệ thống"), 404);
        }

        // Could not decode token: Error while decoding from JSON
        if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json(new ResponseError("BAD_REQUEST", 400, "Phiên đăng nhập hết hạn"), 400);
        }


        return parent::render($request, $exception);
    }
}
