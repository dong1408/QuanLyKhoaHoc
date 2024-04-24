<?php

namespace App\Service\Excel;

use App\Exceptions\Excel\CannotReturnResultFileException;
use App\Exceptions\Excel\FileNotFoundException;
use App\Exceptions\Excel\FormatFileException;
use App\Exceptions\Excel\ValidateFileException;
use App\Exports\DataExport;
use App\Exports\ExportUser;
use App\Imports\ImportUser;
use App\Utilities\ResponseSuccess;
use Google\Service\CloudRetail\GoogleCloudRetailV2RuleForceReturnFacetActionFacetPositionAdjustment;
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
        $headerRow = $worksheet->getRowIterator()->current()->getCellIterator();
        $headerData = [];

        foreach ($headerRow as $cell) {
            $value = $cell->getValue();
            if (!is_null($value) && trim($value) !== '') {
                $headerData[] = $value;
            }
        }
        // Kiểm tra xem tiêu đề cột có đúng không
        $expectedHeaders = ['name', 'username', 'email', 'ngaysinh'];
        if ($headerData !== $expectedHeaders) {
            throw new FormatFileException();
        }
        $import = new ImportUser();
        Excel::import($import, $request->file('file'));
        $dataSucess = $import->getSuccessRecords();
        $dataFail = $import->getFailedRecords();
        $result = array_merge($dataFail, $dataSucess);

        return Excel::download(new DataExport($result), 'result.xlsx');

        // // Tạo tên file duy nhất
        // $filename = 'import_result_' . $this->generateUniqueString();
        // // Lưu file vào hệ thống
        // $isSave = Excel::store(new DataExport($result), $filename . '.xlsx', "import");
        // if (!$isSave) {
        //     throw new CannotReturnResultFileException();
        // }
        // return response()->json($filename, 200);
    }



    public function exportFileResult(Request $request)
    {
        $directory = storage_path('app\\uploads');
        $filename = $request->query('key', "");
        $filePath = $directory . DIRECTORY_SEPARATOR . $filename . '.xlsx';

        if (file_exists($filePath)) {
            // return response()->file($filePath);
            return response()->download($filePath, 'result.xlsx')->deleteFileAfterSend(true);
        } else {
            throw new FileNotFoundException();
        }
    }

    public function export()
    {
        return Excel::download(new ExportUser, 'users.xlsx');
    }


    private function generateUniqueString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        $max = strlen($characters) - 1;

        // Generate a random string
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $max)];
        }

        // Add a unique identifier to ensure uniqueness
        $uniqueId = uniqid();
        $uniqueString = $randomString . $uniqueId;

        // Trim the string to the desired length
        $uniqueString = substr($uniqueString, 0, $length);

        return $uniqueString;
    }
}
