<?php

namespace Animal\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PetOwner extends Model
{
    protected $fillable = ['email', 'phone', 'first_name', 'last_name', 'country_id'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class, 'losses');
    }

    public function losses(): HasMany
    {
        return $this->hasMany(Loss::class);
    }

    public function name(): Attribute
    {
        return Attribute::make(
            get: static fn(mixed $value, array $attributes) => $attributes['first_name'].' '.$attributes['last_name'],
        );
    }
}
