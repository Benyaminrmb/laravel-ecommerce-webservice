<?php

namespace App\Repositories;

use App\Interface\Repository\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    protected $model = Category::class;
}
