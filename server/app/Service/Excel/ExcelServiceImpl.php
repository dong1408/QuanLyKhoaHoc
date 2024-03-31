<?php

namespace App\Service\Excel;

use App\Exports\DataExport;
use App\Exports\ExportUser;
use App\Imports\ImportUser;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelServiceImpl implements ExcelService
{
    public function import(Request $request)
    {
        $import = new ImportUser();
        Excel::import($import, $request->file('file'));
        $dataSucess = $import->getSuccessRecords();
        $dataFail = $import->getFailedRecords();
        $result = array_merge($dataFail, $dataSucess);
        return Excel::download(new DataExport($result), 'result.xlsx');
    }

    public function export()
    {
        return Excel::download(new ExportUser, 'users.xlsx');
    }
}
