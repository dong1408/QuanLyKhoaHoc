<?php

namespace App\Service\GoogleDrive;

use Google_Service_Drive;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface GoogleDriveService
{
    public function getClient(): Google_Service_Drive;

    public function uploadFile(UploadedFile $file): string;
}