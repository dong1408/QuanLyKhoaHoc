<?php

namespace App\Service\GoogleDrive;

use App\ViewModel\Google\FileVm;
use Google_Service_Drive;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

interface GoogleDriveService
{
    public function getClient(): Google_Service_Drive;

    public function uploadFile(UploadedFile $file): FileVm;

    public function deleteFile(string $idFile):void;
}