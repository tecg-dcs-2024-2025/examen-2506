<?php

use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;

$capsule = new Capsule();

$capsule->addConnection([
    'driver' => 'sqlite',
    'host' => '',
    'database' => DATABASE_PATH,
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

$capsule->setEventDispatcher(new Dispatcher(new Container()));

$capsule->setAsGlobal();

$capsule->bootEloquent();
