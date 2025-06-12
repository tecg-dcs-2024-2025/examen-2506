<?php

namespace Animal\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetType extends Model
{
    protected $fillable = ['code'];

    private array $translations;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->translations = require __DIR__.'/../../lang/fr/pet_types.php';
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class);
    }

    protected function translatedFullName(): Attribute
    {
        return Attribute::make(
            get: fn(mixed $value, array $attributes) => $this->translations[$attributes['code']],
        );
    }
}
