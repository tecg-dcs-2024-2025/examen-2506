<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../core/helpers/functions.php';
define('DATABASE_PATH', __DIR__.'/../database.sqlite');
require __DIR__.'/../core/database/dbconnection.php';

/*define('VIEW_DIR', __DIR__.'/../resources/views');*/
define('CONFIG_DIR', __DIR__.'/../config');
define('LANG_DIR', __DIR__.'/../lang');
/**
 * Translated strings
 */
define('MESSAGES', require LANG_DIR.'/fr/validation.php');
define('COUNTRIES', require LANG_DIR.'/fr/countries.php');
define('PET_TYPES', require LANG_DIR.'/fr/pet_types.php');

session_start();

$router = new \Tecgdcs\Router();
$router->route();

$_SESSION['errors'] = null;
$_SESSION['old'] = null;