<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface QuocGiaService
{
    public function getAllQuocGia(): ResponseSuccess;
}
