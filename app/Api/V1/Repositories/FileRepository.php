<?php

namespace App\Api\V1\Repositories;

use Illuminate\Support\Facades\Storage;
use Image;

class FileRepository
{
    public function imageReSize($file,$savePath = '')
    {
        $filePath = $file->hashName($savePath);
        $image      = Image::make($file);
        Storage::put($filePath, (string) $image->encode());
        $image->destroy();
        return generateFileUrl($filePath);
    }
}
