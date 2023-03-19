<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function checkUserExists($username): bool
    {
        $field = static::getField($username);
        return !!!User::query()->where($field, $username)->first();
    }

    public static function fetchUser(array $entry): User
    {
        $arrayEntry = self::getArrayEntry($entry);
        return User::query()->where($arrayEntry['key'], $arrayEntry['value'])->first();
    }

    public static function checkUserHasPassword(User $user): bool
    {
        return !!!User::query()->whereNotNull('password')->first();
    }

    public static function authenticateUser(array $data): User
    {
        return static::createNewUser($data);
    }

    private static function getField($username): string
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL) ? User::EMAIL_FIELD : User::MOBILE_FIELD;
    }

    private static function createNewUser(array $data): User
    {
        return User::create([
            static::getField($data['username']) => $data['username'],
        ]);
    }

}
