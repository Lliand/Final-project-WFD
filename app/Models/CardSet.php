<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CardSet extends Model
{
    protected $guarded = ['id'];

    public function pokemonCards(): HasMany
    {
        return $this->hasMany(PokemonCard::class, 'set_id');
    }
}