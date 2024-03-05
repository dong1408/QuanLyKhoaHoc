<?php

namespace App\Service\QuyDoi;

use App\Utilities\ResponseSuccess;

interface NganhTinhDiemService{
    public function getAllNganhTinhDiem(): ResponseSuccess;
}

?>