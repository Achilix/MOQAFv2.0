<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Favorite extends Model
{
    protected $table = 'favorites';
    protected $primaryKey = 'favorite_id';

    protected $fillable = [
        'user_id',
        'favoritable_type',
        'favoritable_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who favorited.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the favoritable item (Gig or Handyman).
     */
    public function favoritable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Scope to get favorites of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('favoritable_type', $type);
    }

    /**
     * Scope to get recent favorites.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
