<?php

namespace App\Service\Excel;

use App\Exceptions\Excel\FormatFileException;
use App\Exceptions\Excel\ValidateFileException;
use App\Exports\DataExport;
use App\Exports\ExportUser;
use App\Imports\ImportUser;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelServiceImpl implements ExcelService
{
    public function import(Request $request)
    {
        $file = $request->file('file');
        if ($file->getClientOriginalExtension() != 'xlsx') {
            throw new ValidateFileException();
        }

        // Lấy đường dẫn tạm của file
        $filePath = $file->getPathname();
        // Đọc tệp Excel
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();
        // Lấy tiêu đề cột từ hàng đầu tiên của tệp Excel
        $headerRow = $worksheet->getRowIterator()->current();
        $headerData = [];
        foreach ($headerRow->getCellIterator() as $cell) {
            $value = $cell->getValue();
            if (!is_null($value) && trim($value) !== '') {
                $headerData[] = $value;
            }
        }
        // Kiểm tra xem tiêu đề cột có đúng không
        $expectedHeaders = ['name', 'username', 'email', 'ngaysinh'];
        if ($headerData !== $expectedHeaders) {
            // Nếu không đúng, throw lỗi
            throw new FormatFileException();
        }

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
