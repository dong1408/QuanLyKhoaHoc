<?php

namespace App\Exceptions\SanPham;

use App\Utilities\ResponseError;
use Exception;


class LoaiSanPhamWrongException extends Exception
{

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD REQUEST",
                400,
                $this->getMessage()
            ),
            404
        );
    }
}
