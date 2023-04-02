<?php

namespace App\Interface\Repository;

use App\Models\Upload;

interface UploadRepositoryInterface
{
    public function save($file);
    public function update(Upload $upload,$file);
    public function get($id);
    public function softDelete(Upload $upload);
    public function forceDelete(Upload $upload);
    public function restore(Upload $upload);
}
