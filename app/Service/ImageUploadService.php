<?php

namespace App\Service;

use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    private static string $folderName = 'images';

    /**
     * @param $image
     * @return string
     */
    public static function upload($image): string
    {
        return self::store($image);
    }

    protected static function store($file): string
    {
        $relativePath = Storage::disk('public')->putFile(
            self::$folderName,
            $file
        );

        return config('app.storage_url') . $relativePath;
    }
}
