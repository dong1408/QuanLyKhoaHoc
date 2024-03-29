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
        // Excel::import(new ImportUser, $request->file('file')->store('file'));

        $data = [
            ['name' => 'John Doe', 'email' => 'john@example.com'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com'],
            // Các dòng dữ liệu khác
        ];
        return Excel::download(new ExportUser, 'users.xlsx');
        // return Excel::download(new DataExport($data), 'abc.xlsx');
        
    }

    public function export()
    {
        return Excel::download(new ExportUser, 'users.xlsx');
    }
}
