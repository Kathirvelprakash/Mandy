<?php
declare(strict_types=1);

class InputSanitizer
{
    public static function sanitize(string $input): string
    {
        return htmlspecialchars(stripslashes(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    public static function sanitizeDate(string $input): string
    {
        return date('Y-m-d', strtotime(trim($input)));
    }

    public static function sanitizeArray(array $inputs): string
    {
        $clean = array_map([self::class, 'sanitize'], $inputs);
        return implode(", ", $clean);
    }
}