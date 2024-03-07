<?php

namespace App\Service\QuyDoi;

use App\Utilities\ResponseSuccess;

interface ChuyenNganhTinhDiemService{
    public function getAllChuyenNganhTinhDiem();
    public function getChuyeNganhTinhDiemByIdNganhTinhDiem(int $id);
}

?>