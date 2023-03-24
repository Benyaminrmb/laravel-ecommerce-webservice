<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()
            ->count(5)
            ->create();

        // Create parent categories
        Category::factory()
            ->count(5)
            ->create()
            ->each(function ($parentCategory) {
                // Create child categories for each parent category
                $childCategories = Category::factory()
                    ->count(3)
                    ->make();

                // Attach child categories to parent category
                $parentCategory->children()->saveMany($childCategories);
            });
    }
}
