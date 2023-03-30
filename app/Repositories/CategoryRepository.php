<?php

namespace App\Repositories;

use App\Interface\Repository\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;
    public function trash(int $id): bool
    {
        return $this->query->find($id)->delete();
    }

    public function restore(int $id): bool
    {
        return $this->query->find($id)->restore();
    }
}
