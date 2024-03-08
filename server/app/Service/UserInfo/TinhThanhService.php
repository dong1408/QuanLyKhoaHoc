<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface TinhThanhService
{
    public function getAllTinhThanh(): ResponseSuccess;
    public function getAllTinhThanhByIdQuocGia(int $id): ResponseSuccess;
}
