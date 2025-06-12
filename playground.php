<?php

/**
 * Un bac à sable pour tester le fonctionnement de certaines fonctions PHP
 */

require __DIR__.'/vendor/autoload.php';
require __DIR__.'/core/helpers/functions.php';
define('DATABASE_PATH', __DIR__.'/database.sqlite');
require __DIR__.'/core/database/dbconnection.php';

// Nombre d'itérations pour tester les performances
$iterations = 1000000;

// Test avec des guillemets simples (sans variable)
$name = 'Marie';
$start = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $str = 'Bonjour '.$name;
}
$end = microtime(true);
echo "Temps avec des guillemets simples : ".($end - $start)." secondes\n";

// Test avec des guillemets doubles (avec variable)
$start = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $str = "Bonjour $name";
}
$end = microtime(true);
echo "Temps avec des guillemets doubles : ".($end - $start)." secondes\n";

// Test avec des guillemets doubles (avec variable)
$start = microtime(true);
for ($i = 0; $i < $iterations; $i++) {
    $str = "Bonjour {$name}";
}
$end = microtime(true);
echo "Temps avec des guillemets doubles et une curly extra : ".($end - $start)." secondes\n";

