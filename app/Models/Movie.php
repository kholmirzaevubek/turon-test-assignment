<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movie extends Model
{
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'genre_id',
        'upload',
        'released_date',
        'trailer_link',
    ];

    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
