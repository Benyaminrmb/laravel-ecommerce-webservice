<?php

namespace Database\Factories;

use App\Models\Role;
use App\Enums\Role as RoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Role>
 */
class RoleFactory extends Factory
{
    protected $model= Role::class;
    public function definition(): array
    {
        return [
            'name'=>Arr::random(RoleEnum::cases())
        ];
    }
}
