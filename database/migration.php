<?php

require __DIR__.'/../vendor/autoload.php';
define('DATABASE_PATH', __DIR__.'/../database.sqlite');
require __DIR__.'/../core/database/dbconnection.php';

use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->dropIfExists('users');
Capsule::schema()->create('users', function ($table) {
    $table->id();
    $table->string('email')->unique();
    $table->string('password');
    $table->timestamps();
});

Capsule::schema()->dropIfExists('countries');
Capsule::schema()->create('countries', function ($table) {
    $table->id();
    $table->string('code')->unique();
    $table->timestamps();
});

Capsule::schema()->dropIfExists('pet_types');
Capsule::schema()->create('pet_types', function ($table) {
    $table->id();
    $table->string('code')->unique();
    $table->timestamps();
});

Capsule::schema()->dropIfExists('pet_owners');
Capsule::schema()->create('pet_owners', function ($table) {
    $table->id();
    $table->string('first_name')->nullable();
    $table->string('last_name')->nullable();
    $table->string('email')->unique();
    $table->string('phone')->nullable();
    $table->foreignId('country_id')
        ->constrained();
    $table->timestamps();
});

Capsule::schema()->dropIfExists('pets');
Capsule::schema()->create('pets', function ($table) {
    $table->id();
    $table->string('name');
    $table->string('chip');
    $table->boolean('gender')->nullable();
    $table->smallInteger('age')->nullable();
    $table->string('race')->nullable();
    $table->string('tattoo')->nullable();
    $table->text('description')->nullable();
    $table->string('photo_path')->nullable();
    $table->foreignId('pet_type_id')
        ->constrained();
    $table->timestamps();
});

Capsule::schema()->dropIfExists('losses');
Capsule::schema()->create('losses', function ($table) {
    $table->id();
    $table->timestamp('lost_at');
    $table->timestamp('solved_at')
        ->nullable();
    $table->smallInteger('postal_code');
    $table->foreignId('country_id')
        ->constrained();
    $table->foreignId('pet_id')
        ->constrained();
    $table->foreignId('pet_owner_id')
        ->constrained();
    $table->foreignId('user_id')
        ->nullable()
        ->constrained();
    $table->timestamps();
});
