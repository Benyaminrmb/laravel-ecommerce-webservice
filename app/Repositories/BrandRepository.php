<?php

namespace App\Repositories;

use App\Interface\Repository\BrandRepositoryInterface;
use App\Models\Brand;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    protected $model = Brand::class;

    public function trash(int $id): bool
    {
        return $this->query->find($id)->delete();
    }

    public function restore(int $id): bool
    {
        return $this->query->find($id)->restore();
    }

}
