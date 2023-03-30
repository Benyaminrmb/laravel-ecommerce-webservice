<?php

namespace App\Interface\Repository;

use App\Models\Brand;

interface BaseRepositoryInterface
{
    public function findById(int $id);
}
