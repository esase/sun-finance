<?php

namespace SunFinance\Core\Utils;

class Url
{
    const BASE_SCRIPT_NAME = '/index.php';

    /**
     * @return string
     */
    public static function getRequestedUri(): string
    {
        $requestedUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // remove the base script name from the requested uri (we may be worked from a sub dir)
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        $scriptPath = str_replace(
            self::BASE_SCRIPT_NAME,
            '',
            $scriptName
        );
        return strtolower(str_replace($scriptPath, '', $requestedUri));
    }

    /**
     * @return string
     */
    public static function getRequestedMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'] ?? '';
    }
}