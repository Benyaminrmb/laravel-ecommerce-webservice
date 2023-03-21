<?php

namespace Database\Factories;

use App\Enums\UserEntryTypeEnum;
use App\Models\UserEntry;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserEntryFactory extends Factory
{
    protected $model = UserEntry::class;

    public function definition(): array
    {
        $type = Arr::random(UserEntryTypeEnum::cases());
        $entry = $type === UserEntryTypeEnum::EMAIL ? $this->faker->safeEmail : $this->faker->phoneNumber;

        return [
            'type' => $type,
            'entry' => $entry,
            'verified_at' => Arr::random([$this->faker->dateTime, null]),
        ];
    }
}
