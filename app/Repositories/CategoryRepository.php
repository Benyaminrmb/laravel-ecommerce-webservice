<?php

namespace App\Repositories;

use App\Interface\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll():\Illuminate\Database\Eloquent\Collection
    {
        return Category::whereNull('parent_id')->latest()->get();
    }

    public function getById($id): Category
    {
        return Category::findOrFail($id);
    }

    public function trash(Category $category): bool
    {
        return $category->delete();
    }
    public function restore(Category $category): bool
    {
        return $category->restore();
    }

    public function create(array $details)
    {
        Category::create($details);
    }

    public function update($id, array $newDetails)
    {
        Category::whereId($id)->update($newDetails);
    }
}
