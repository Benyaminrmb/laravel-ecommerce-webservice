<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Upload;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Upload>
 */
class UploadFactory extends Factory
{
    protected $model = Upload::class;
    public function definition(): array
    {
        return [
            'user_id'  => function () {
                return User::factory()->create()->id;
            },
            'path' => $this->faker->imageUrl(),
            'title' => $this->faker->sentence,
        ];
    }
}
