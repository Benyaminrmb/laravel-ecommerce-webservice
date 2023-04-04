<?php

namespace App\Services;

use Carbon\Carbon;

class EmailVerifyService
{
    public static $min = 1000;

    public static $max = 9999;

    public static string $prefix = 'email_verify_';

    public static function store($userId, $code, Carbon $time = null)
    {
        $time = $time ? $time : now()->addHour();
        cache()->put(static::$prefix.$userId, $code, $time);
    }

    public static function checkCodeIsValid($user, $inputCode): bool
    {
        $userCode = self::getUserCode($user->id);
        if ($userCode == $inputCode) {
            static::deleteCode($userCode);

            return true;
        }

        return false;
    }

    private static function getUserCode($userId)
    {
        if (cache()->has(static::$prefix.$userId)) {
            return cache()->get(static::$prefix.$userId);
        }

        return null;
    }

    private static function deleteCode($key): void
    {
        cache()->forget($key);
    }

    public static function generateCode(): int
    {
        return random_int(static::$min, static::$max);
    }
}
