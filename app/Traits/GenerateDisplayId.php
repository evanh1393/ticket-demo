<?php

namespace App\Traits;

use Carbon\Carbon;

trait GenerateDisplayId
{
    /**
     * Generates a unique display identifier.
     *
     * @param string $prefix
     * @return string
     * @throws \Exception
     */
    public static function generateDisplayId(string $prefix): string
    {
        $year = Carbon::now()->year;
        for ($i = 0; $i < 5; $i++) {
            $displayId = $prefix . '_' . $year . '_' . self::generateRandomString(10);
            if (!self::displayIdExists($displayId)) {
                return $displayId;
            }
        }

        throw new \Exception('Failed to generate a unique display ID after 5 attempts.');
    }

    /**
     * Generates a random string of specified length.
     *
     * @param int $length
     * @return string
     */
    protected static function generateRandomString(int $length): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    /**
     * Checks if a display ID already exists in the database.
     *
     * @param string $displayId
     * @return bool
     */
    protected static function displayIdExists(string $displayId): bool
    {
        return self::where('display_id', $displayId)->exists();
    }
}
