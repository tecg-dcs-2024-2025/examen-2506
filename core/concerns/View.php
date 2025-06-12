<?php

namespace Tecgdcs\Concerns;

use Random\RandomException;

trait View
{
    /**
     * @throws RandomException
     */
    public function compileCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return <<<HTML
<input name="_csrf" type="hidden" value="{$_SESSION['csrf_token']}">
HTML.PHP_EOL;
    }
}