<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RoleEnum;
use App\Enums\UserEntryTypeEnum;
use App\Models\Role;
use App\Models\UserEntry;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
        ]);
        \App\Models\User::factory()->state(new Sequence(
            function ($sequence) {
                return [
                    'password' => \Hash::make('a'),
                    'role_id' => Role::where('name', RoleEnum::ADMIN->value)->first()->id,
                ];
            },
        ))->has(UserEntry::factory()->state(new Sequence(
            function ($sequence) {
                return [
                    'entry' => 'a@a.com',
                    'verified_at' => \Date::now(),
                    'type' => UserEntryTypeEnum::EMAIL->value,
                    'is_main' => true,
                ];
            },
        )), 'entries')->create();
        \App\Models\User::factory(10)->create();
    }
}
