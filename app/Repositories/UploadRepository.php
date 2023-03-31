<?php

namespace App\Repositories;

use App\Interface\Repository\UploadRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class UploadRepository implements UploadRepositoryInterface
{
    public function save($file, $fileName = null)
    {
        if ($fileName === null) {
            $fileName = $file->getClientOriginalName();
        }

        // Change the file name if needed
        $extension = $file->getClientOriginalExtension();
        $fileName = str_replace(".$extension", '', $fileName);
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName);
        $fileName = $fileName . '_' . time() . '.' . $extension;

        // Save the file to storage
        $path = $file->storeAs('uploads', $fileName, 'public');

        return $path;
    }
}
