<?php

namespace Animal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loss extends Model
{
    protected $fillable = ['lost_at', 'solved_at', 'postal_code', 'country_id', 'pet_owner_id', 'pet_id', 'user_id'];

    public function pet_owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    protected function casts(): array
    {
        return [
            'lost_at' => 'datetime',
        ];
    }
}
