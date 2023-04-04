<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use App\Models\UserEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->entries()->saveMany(UserEntry::factory(rand(1, 2))->make([
                'user_id' => $user->id,
                'is_main' => ! ($user->entries()->count() > 0),
            ]));
        });
    }

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'role_id' => Role::inRandomOrder()->first()->id,
            'password' => bcrypt('password'), // password
            'remember_token' => Str::random(10),
        ];
    }
}
