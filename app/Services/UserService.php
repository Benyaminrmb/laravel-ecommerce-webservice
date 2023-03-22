<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\UserEntry;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public static function findById(int $id)
    {
        return User::query()->where('id', $id)->first();
    }

    public static function isVerified(User $user): bool
    {
        return $user->entries()->whereNot('verified_at')->count() > 0;
    }

    public static function isEntryVerified(UserEntry $entry): bool
    {
        if (empty($entry->verified_at)) {
            return false;
        }

        return true;
    }

    public static function createToken(User $user): string
    {
        return $user->createToken('Token Name')->accessToken;
    }
    public static function updateUser(User $user , Array $data)
    {
        return tap($user)->update($data);
    }
    public static function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    public static function fetch(array $entry): User|null
    {
        $arrayEntry = self::getArrayEntry($entry);

        return User::query()->searchEntry($arrayEntry['key'], $arrayEntry['value'])->first();
    }

    public static function hasPassword(User $user): bool
    {
        if (empty($user->password)) {
            return false;
        }

        return true;
    }

    public static function create(array $entry): User
    {
        $arrayEntry = self::getArrayEntry($entry);
        $user = User::create();
        $user->entries()->create([
            'type' => $arrayEntry['key'],
            'entry' => $arrayEntry['value'],
            'is_main' => ! ($user->entries()->count() > 0),
        ]);
        $user->refresh();

        return $user;
    }

    public static function verifyUser(User $user): User
    {
        return tap($user)->update([
            'role_id' => Role::where('name', \App\Enums\RoleEnum::VERIFIED_USER->value)->first()->id,
        ]);
    }

    public static function verifyEntry(UserEntry $entry): UserEntry
    {
        tap($entry)->update([
            'verified_at' => $entry->freshTimestamp(),
        ]);

        return $entry->refresh();
    }

    public static function getArrayEntry(array $entry): array
    {
        $key = current(array_keys($entry));
        $value = current(array_values($entry));

        return [
            'key' => $key,
            'value' => $value,
        ];
    }
}
