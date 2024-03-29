<?php

namespace App\Service\GoogleDrive;

use App\Exceptions\Google\KhongTimThayFolderException;
use App\Utilities\Convert;
use App\ViewModel\Google\FileVm;
use Exception;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class GoogleDriveServiceImpl implements GoogleDriveService
{
    protected Google_Service_Drive $client;

    public function __construct()
    {
        $goole_client = new Google_Client();
        $goole_client->setAuthConfig("../private/".env('GOOGLE_DRIVE_JSON_AUTH'));
        $goole_client->addScope([Google_Service_Drive::DRIVE]);

        $this->client = new Google_Service_Drive($goole_client);
    }

    public function getClient(): Google_Service_Drive
    {
        return $this->client;
    }

    /**
     * @throws \Google\Service\Exception
     * @throws KhongTimThayFolderException
     */
    public function uploadFile(UploadedFile $file): FileVm
    {
        $folderId = env("FOLDER_ID");


        if(!$folderId){
            throw new KhongTimThayFolderException();
        }

        $fileMetadata = new DriveFile([
            "name" => $file->getClientOriginalName(),
            "parents" => [$folderId]
        ]);

        $uploadFile = $this->client->files->create($fileMetadata,
        [
           'data' => file_get_contents($file->getRealPath()),
           'mimeType' => 'application/octet-stream',
           'uploadType' => 'multipart',
           'fields' => 'id,webViewLink'
        ]);

        //tạo quyền xem cho tệp
        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader'
        ]);

        $fileId = $uploadFile->id;

        $this->client->permissions->create($fileId, $permission, ['fields' => 'id']);

        return Convert::getFileVm($uploadFile->id,$uploadFile->webViewLink);
    }

    /**
     * @throws \Google\Service\Exception
     */
    public function deleteFile(string $idFile): void
    {
        $this->client->files->delete($idFile);
    }
}