<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradingRequest extends Model
{
    protected $guarded = ['id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'grader_id');
    }

    public function pokemonCard(): BelongsTo
    {
        return $this->belongsTo(PokemonCard::class, 'card_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(GradingPackage::class, 'package_id');
    }
}
