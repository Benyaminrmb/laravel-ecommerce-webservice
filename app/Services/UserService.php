<?php

namespace App\Services;

use App\Enums\Role as EnumRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{
    public static function checkUserExists(array $entry): bool
    {
        $arrayEntry = self::getArrayEntry($entry);

        return User::query()->where($arrayEntry['key'], $arrayEntry['value'])->exists();
    }

    public static function isUserVerified(User $user): bool
    {
        if (empty($user->email_verified_at) && empty($user->phone_number_verified_at)) {
            return false;
        }

        return true;
    }

    public static function createToken(User $user): string
    {
        return $user->createToken('Token Name')->accessToken->token;
    }

    public static function checkUserCredentials(array $entry, string $password): bool
    {
        $arrayEntry = self::getArrayEntry($entry);
        $credentials = [
            $arrayEntry['key'] => $arrayEntry['value'],
            'password' => $password,
        ];

        return Auth::attempt($credentials);
    }

    public static function fetchUser(array $entry): User
    {
        $arrayEntry = self::getArrayEntry($entry);

        return User::query()->where($arrayEntry['key'], $arrayEntry['value'])->first();
    }

    public static function checkUserHasPassword(User $user): bool
    {
        if (empty($user->password)) {
            return false;
        }

        return true;
    }

    private static function getField($username): string
    {
        return filter_var($username, FILTER_VALIDATE_EMAIL) ? User::EMAIL_FIELD : User::MOBILE_FIELD;
    }

    public static function createNewUser(array $entry): User
    {
        $arrayEntry = self::getArrayEntry($entry);
        $roleId = Role::where('name', EnumRole::UNVERIFIED_USER->value)->first()->id;

        return User::create([
            $arrayEntry['key'] => $arrayEntry['value'],
            'role_id' => $roleId,
        ]);
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
