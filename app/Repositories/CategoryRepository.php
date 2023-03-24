<?php

namespace App\Repositories;

use App\Interface\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll():\Illuminate\Database\Eloquent\Collection
    {
        return Category::all();
    }

    public function getById($id): Category
    {
        return Category::findOrFail($id);
    }

    public function delete($id)
    {
        Category::destroy($id);
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
