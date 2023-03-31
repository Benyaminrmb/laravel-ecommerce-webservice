<?php

namespace App\Interface\Repository;

interface UploadRepositoryInterface
{
    public function save($file, $fileName = null);
}
