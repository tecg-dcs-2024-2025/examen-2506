<?php

namespace Animal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pet extends Model
{
    protected $fillable =
        ['name', 'chip', 'tattoo', 'age', 'pet_type_id', 'race', 'gender', 'description', 'photo_path'];

    public function pet_type(): BelongsTo
    {
        return $this->belongsTo(PetType::class);
    }

    public function pet_owners(): BelongsToMany
    {
        return $this->belongsToMany(PetOwner::class, 'losses');
    }

    public function losses(): HasMany
    {
        return $this->hasMany(Loss::class);
    }

    protected function casts(): array
    {
        return ['tattoo' => 'array',];
    }
}
