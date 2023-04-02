<?php

namespace App\Repositories;

use App\Interface\Repository\UploadRepositoryInterface;
use App\Models\Upload;
use Illuminate\Support\Facades\Storage;

class UploadRepository implements UploadRepositoryInterface
{
    public function save($file): false|string
    {
        // Save the file to storage
        return Storage::disk('public')->putFile(
            'uploads', $file
        );
    }

    public function update(Upload $upload,$file): false|string
    {
        if(Storage::disk('public')->delete($upload->path)){
            return $this->save($file);
        }
        return false;
    }

    public function get($id,$userId=null):Upload|null
    {
        return Upload::find($id);
    }
}
