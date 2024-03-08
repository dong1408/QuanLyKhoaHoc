<?php

namespace App\Exceptions\TapChi;

use App\Utilities\ResponseError;
use Exception;


class TinhDiemTapChiException extends Exception
{
    public function render($request)
    {
        return response()->json(
            new ResponseError(
                "BAD_REQUEST",
                400,
                "Chuyên ngành tính điểm không nằm trong ngành tính điểm"
            ),
            400
        );
    }
}
