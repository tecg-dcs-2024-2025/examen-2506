<?php

namespace Tecgdcs;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    public const int BAD_REQUEST = 400;
    public const int NOT_FOUND = 404;
    public const int SEE_OTHER = 303;
    public const int SERVER_ERROR = 500;
    public const int UNAUTHORIZED = 401;

    #[NoReturn]
    public static function abort($code = self::NOT_FOUND): void
    {
        http_response_code($code);
        View::make("codes.$code");
        exit;
    }

    #[NoReturn]
    public static function back(): void
    {
        $previousUrl = $_SERVER['HTTP_REFERER'] ?? '/';
        self::redirect($previousUrl);
    }

    #[NoReturn]
    public static function redirect(string $url): void
    {
        http_response_code(self::SEE_OTHER);
        header("Location: $url");
        exit;
    }
}
