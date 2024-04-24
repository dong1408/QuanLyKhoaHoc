<?php

namespace App\Service\Excel;

use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface ExcelService
{

    public function import(Request $request);
    public function exportFileResult(Request $request);
    public function export();
}
