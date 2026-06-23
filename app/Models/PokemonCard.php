<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PokemonCard extends Model
{
    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cardSet(): BelongsTo
    {
        return $this->belongsTo(CardSet::class, 'set_id');
    }

    // Relasi 1:1 ke Grading Request
    public function gradingRequest(): HasOne
    {
        return $this->hasOne(GradingRequest::class, 'card_id');
    }
}
