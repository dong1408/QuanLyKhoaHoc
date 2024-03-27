<?php

namespace App\Service\GoogleDrive;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveServiceImpl implements GoogleDriveService
{
    protected Google_Service_Drive $client;

    public function __construct()
    {
        $goole_client = new Google_Client();
        $goole_client->setAuthConfig("");
        $goole_client->addScope([Google_Service_Drive::DRIVE]);

        $this->client = new Google_Service_Drive($goole_client);
    }

    public function getClient(): Google_Service_Drive
    {
        return $this->client;
    }

}