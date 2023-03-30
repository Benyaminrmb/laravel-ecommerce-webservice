<?php

namespace App\Interface\Repository;

use App\Models\Brand;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function getAll();

    public function trash(int $id);

    public function restore(int $id);

    public function create(array $details);

    public function update(int $id, array $newDetails);
}
