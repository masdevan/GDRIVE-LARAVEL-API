<?php

namespace App\Services;

use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;

class GoogleDriveService
{
    private $driveService;
    private $parentFolderId;

    public function __construct()
    {
        $this->initializeGoogleDriveService();
    }

    private function initializeGoogleDriveService()
    {
        $client = new GoogleClient();
        $client->setAuthConfig(storage_path('app/credentials/credentials.json'));
        $client->addScope(GoogleDrive::DRIVE_FILE);

        $this->driveService = new GoogleDrive($client);
        $this->parentFolderId = '11pNqV5LLvWyd8MiX4qhyar0JqIrIQ1Eu'; // Ubah sesuai ID folder Google Drive Anda
    }

    public function uploadFile($filePath, $fileName)
    {
        $fileMetadata = [
            'name' => $fileName,
            'parents' => [$this->parentFolderId],
        ];

        $file = new \Google\Service\Drive\DriveFile($fileMetadata);
        $content = file_get_contents($filePath);

        $uploadedFile = $this->driveService->files->create(
            $file,
            [
                'data' => $content,
                'mimeType' => mime_content_type($filePath),
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink, webContentLink',
            ]
        );

        return [
            'viewLink' => $uploadedFile->getWebViewLink(),
            'downloadLink' => $uploadedFile->getWebContentLink(),
        ];
    }

    public function createFolder($folderName)
    {
        $fileMetadata = [
            'name' => $folderName,
            'parents' => [$this->parentFolderId],
            'mimeType' => 'application/vnd.google-apps.folder',
        ];

        $folder = $this->driveService->files->create(
            new \Google\Service\Drive\DriveFile($fileMetadata),
            ['fields' => 'id, name']
        );

        return [
            'id' => $folder->id,
            'name' => $folder->name,
        ];
    }
}
