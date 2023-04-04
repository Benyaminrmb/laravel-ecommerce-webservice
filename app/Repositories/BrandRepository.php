<?php

namespace App\Repositories;

use App\Interface\Repository\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    protected string $model = Brand::class;
}
