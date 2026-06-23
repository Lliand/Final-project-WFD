<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradingPackage extends Model
{
    protected $guarded = ['id'];

    public function gradingRequests(): HasMany
    {
        return $this->hasMany(GradingRequest::class, 'package_id');
    }
}