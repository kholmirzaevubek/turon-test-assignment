<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Genre extends Model
{
    protected $fillable = ['id', 'user_id', 'name'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
