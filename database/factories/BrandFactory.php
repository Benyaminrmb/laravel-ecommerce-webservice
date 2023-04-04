<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Upload;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'logo_id' => function () {
                return Upload::factory()->create()->id;
            },
        ];
    }
}
