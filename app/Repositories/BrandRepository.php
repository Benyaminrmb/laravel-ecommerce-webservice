<?php

namespace App\Repositories;

use App\Interface\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository implements BrandRepositoryInterface
{
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return Brand::latest()->get();
    }

    public function getById(Brand $brand): Brand
    {
        return $brand;
    }

    public function trash(Brand $brand): bool
    {
        return $brand->delete();
    }

    public function restore(Brand $brand): bool
    {
        return $brand->restore();
    }

    public function create(array $details)
    {
        return Brand::create($details);
    }

    public function update(Brand $brand, array $newDetails): Brand
    {
        $brand->update($newDetails);

        return $brand->refresh();
    }
}
