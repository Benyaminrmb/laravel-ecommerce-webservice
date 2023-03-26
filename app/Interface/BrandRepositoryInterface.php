<?php

namespace App\Interface;

use App\Models\Brand;

interface BrandRepositoryInterface
{
    public function getAll();

    public function getById(Brand $brand);

    public function trash(Brand $brand);

    public function restore(Brand $brand);

    public function create(array $details);

    public function update(Brand $brand, array $newDetails);
}
