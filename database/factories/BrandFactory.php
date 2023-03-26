<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BrandFactory extends Factory
{
    protected $model = Brand::class;
    public function configure(): static
    {
        return $this->afterMaking(function (Brand $brand) {
            // ...
        })->afterCreating(function (Brand $brand) {
            // ...
        });
    }

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'logo_id' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
