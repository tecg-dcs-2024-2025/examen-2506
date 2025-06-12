<?php

require __DIR__.'/../vendor/autoload.php';
define('DATABASE_PATH', __DIR__.'/../database.sqlite');
require __DIR__.'/../core/database/dbconnection.php';
$pet_types = array_keys(require __DIR__.'/../lang/fr/pet_types.php');
$countries_csv = __DIR__.'/countries.csv';

use Animal\Models\Country;
use Animal\Models\Loss;
use Animal\Models\Pet;
use Animal\Models\PetOwner;
use Animal\Models\PetType;
use Animal\Models\User;
use Carbon\Carbon;

$faker = Faker\Factory::create();

User::query()->truncate();
$password = password_hash('change_this', PASSWORD_BCRYPT);
$dominique = User::create([
    'email' => 'dominique.vilain@hepl.be',
    'password' => $password,
]);


while (($i = ($i ?? 0)) < 100) {
    User::create([
        'email' => $faker->unique(maxRetries: 3)->safeEmail(),
        'password' => $password
    ]);
    $i++;
}

$countries_csv = __DIR__.'/countries.csv';
$file_handle = fopen($countries_csv, 'rb');
// Récupérer les entêtes du CSV
$headers = fgetcsv($file_handle, 1000, escape: '');
// Mettre en lien les langues supportées par l'app avec les entêtes qui leur correspondent
$available_languages = ['EN' => 'name.common', 'FR' => 'translations.fra.common'];
// Récupérer l'indice de la colonne qui contient le code cca2
$cca2_index = array_find_key($headers, fn($item) => $item === 'cca2');
// Récupérer les indices des colonnes qui contiennent les traductions utiles dans notre app
$header_indexes = [];
foreach ($available_languages as $cca2 => $translation_header) {
    $header_indexes[$cca2] = array_find_key($headers, fn($item) => $item === $translation_header);
}


// Préparer les chaînes à écrire dans les fichiers php. On commence par le code qui définit un array
foreach (array_keys($available_languages) as $lang_code) {
    $$lang_code = "<?php return [".PHP_EOL;
}
// Pour la db, on aura d'un besoin d'un array des cca2 qui sont dans le csv
$cca2s = [];
// On commence à parcourir le csv, une ligne à la fois
while ($country_row = fgetcsv($file_handle, 1000, escape: '')) {
    //Certains caractères peuvent casser l'analyse apparemment. Ce test est une petite précaution 🤞🍀
    if (count($country_row) === count($headers)) {
        // Pour chaque langue, on peut alors compléter l'array pour le pays en cours.
        foreach (array_keys($available_languages) as $lang_code) {
            $cca2 = $country_row[$cca2_index];
            $$lang_code .= "'".$cca2."' => '".str_replace("'", "\'",
                    $country_row[$header_indexes[$lang_code]])."',".PHP_EOL;
        }
        // Et on n'oublie pas d'ajouter le cca2 du pays en cours dans l'array des cca2 dont on aura besoin dans la db
        $cca2s[] = $country_row[$cca2_index];
    }
}
// On finalise le code php qu'on doit écrire dans les fichiers, et on l'écrit.
foreach (array_keys($available_languages) as $lang_code) {
    $$lang_code .= "];".PHP_EOL;
    file_put_contents(__DIR__.'/../lang/'.$lang_code.'/countries.php', $$lang_code);
}


Country::query()->truncate();
foreach ($cca2s as $code) {
    Country::create(compact('code'));
}


PetType::query()->truncate();
foreach ($pet_types as $code) {
    PetType::create(compact('code'));
}

PetOwner::query()->truncate();
$belgium = Country::where('code', 'BE')->first();
$belgium->pet_owners()->create([
    'first_name' => 'Dominique',
    'last_name' => 'Vilain',
    'email' => $dominique->email,
]);

foreach (Country::all()->random(20) as $country) {
    try {
        $p_o_count = random_int(3, 20);
    } catch (\Random\RandomException $e) {
        $p_o_count = 3;
    }
    for ($i = 1; $i <= $p_o_count; $i++) {
        $country->pet_owners()->create([
            'first_name' => $faker->firstName(),
            'last_name' => $faker->lastName(),
            'email' => $faker->unique(maxRetries: 3)->safeEmail(),
            'country_id' => Country::inRandomOrder()->first()->id,
        ]);
    }
}

Pet::query()->truncate();

$bird = PetType::where('code', 'bird')->first();
$bird->pets()->create([
    'name' => 'titi',
    'chip' => $faker->ean8(),
    'tattoo' => ['position' => 'ER', 'code' => $faker->ean8()]
]);

Pet::create([
    'name' => 'rocky',
    'chip' => $faker->ean8(),
    'pet_type_id' => PetType::where('code', 'dog')->first()->id,
]);

for ($i = 1; $i <= 200; $i++) {
    Pet::create([
        'name' => $faker->firstName(),
        'chip' => $faker->ean8(),
        'pet_type_id' => PetType::inRandomOrder()->first()->id,
    ]);
}

Loss::query()->truncate();

$rocky = Pet::where('name', 'rocky')->first();
$not_dominique = PetOwner::where('email', '!=', $dominique->email)->first();
$france = Country::where('code', 'FR')->first();
$lost_at_dom = Carbon::now()->subMonths(2);
$lost_at_not_dom = Carbon::now()->subMonths(1);
$postal_code = 75675;

Loss::create([
    'pet_id' => $rocky->id,
    'pet_owner_id' => $dominique->id,
    'country_id' => $france->id,
    'postal_code' => $postal_code,
    'lost_at' => $lost_at_dom,
    'user_id' => $dominique->id,

]);

Loss::create([
    'pet_id' => $rocky->id,
    'pet_owner_id' => $not_dominique->id,
    'country_id' => $france->id,
    'postal_code' => $postal_code,
    'lost_at' => $lost_at_not_dom,
]);


for ($i = 1; $i < 10; $i++) {
    $lost_at = $faker->dateTimeBetween('-10 months');
    Loss::create([
        'pet_id' => Pet::inRandomOrder()->first()->id,
        'pet_owner_id' => $dominique->id,
        'country_id' => Country::inRandomOrder()->first()->id,
        'postal_code' => random_int(1000, 9999),
        'lost_at' => $lost_at,
        'solved_at' => random_int(0,1) ? $faker->dateTimeBetween($lost_at) : null,
        'user_id' => $dominique->id,
    ]);
}

for ($i = 1; $i < 20; $i++) {
    Loss::create([
        'pet_id' => Pet::inRandomOrder()->first()->id,
        'pet_owner_id' => PetOwner::inRandomOrder()->first()->id,
        'country_id' => Country::inRandomOrder()->first()->id,
        'postal_code' => random_int(1000, 9999),
        'lost_at' => $faker->dateTimeBetween('-10 months'),
    ]);
}