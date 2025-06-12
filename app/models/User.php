<?php

namespace Animal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Model
{
    protected $fillable = ['email', 'password'];

    public function losses(): HasMany
    {
        return $this->hasMany(Loss::class);
    }
}