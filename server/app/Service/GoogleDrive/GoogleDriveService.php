<?php

namespace App\Service\GoogleDrive;

use Google_Service_Drive;

interface GoogleDriveService
{
    public function getClient(): Google_Service_Drive;
}