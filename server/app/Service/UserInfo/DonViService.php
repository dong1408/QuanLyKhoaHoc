<?php

namespace App\Service\UserInfo;

use App\Utilities\ResponseSuccess;

interface DonViService
{
    public function getAllDonVi(): ResponseSuccess;
}
