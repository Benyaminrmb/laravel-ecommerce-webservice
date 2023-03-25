<?php

namespace App\Interface;

use App\Models\Category;

interface CategoryRepositoryInterface
{
    public function getAll();

    public function getById(Category $category);

    public function trash(Category $category);

    public function restore(Category $category);

    public function create(array $details);

    public function update(Category $category, array $newDetails);
}
