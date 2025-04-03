<?php

namespace App\Services;

use ImageKit\ImageKit;

class ImageKitService
{
    protected $imageKit;

    public function __construct()
    {
        $this->imageKit = new ImageKit(
            env('IMAGEKIT_PUBLIC_KEY'),
            env('IMAGEKIT_PRIVATE_KEY'),
            env('IMAGEKIT_URL_ENDPOINT')
        );
    }

    public function upload(string $path, string $folder = 'general'): ?string
    {
        $fullPath = storage_path("app/{$path}");

        if (!file_exists($fullPath)) {
            return null;
        }

        $response = $this->imageKit->upload([
            'file' => fopen($fullPath, 'r'),
            'fileName' => basename($fullPath),
            'folder' => "/{$folder}",
            'useUniqueFileName' => true,
        ]);

        return $response->result->url ?? null;
    }

    public function deleteImage($fileId)
    {
        return $this->imageKit->deleteFile($fileId);
    }
}
