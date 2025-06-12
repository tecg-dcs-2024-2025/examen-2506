<?php

namespace Tecgdcs;

use eftec\bladeone\BladeOne;

class View extends BladeOne
{
    use concerns\View;

    private const VIEW_DIR = __DIR__.'/../resources/views';
    private const CACHE_DIR = __DIR__.'/../storage/cache';

    public static function make(string $template, array $data = [])
    {
        $instance = new self(self::VIEW_DIR, self::CACHE_DIR, self::MODE_DEBUG);
        if (isset($_SESSION['user'])) {
            $instance->setAuth($_SESSION['user']->email);
        }
        echo $instance->run($template, $data);
    }
}