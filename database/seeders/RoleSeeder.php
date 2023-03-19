<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = \App\Enums\Role::cases();
        foreach ($roles as $role) {
            Role::query()->firstOrCreate([
                'name' => $role->value,
            ]);
        }
    }
}
