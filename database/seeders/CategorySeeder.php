<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Create parentless categories
        Category::factory(5)->create();

        // Create categories with a random parent
        Category::factory(5)->create()->each(function ($category) {
            $parent = Category::inRandomOrder()->first();
            $category->parent_id = $parent->id;
            $category->save();
        });
    }
}
