<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    protected $table = 'reviews';
    protected $primaryKey = 'review_id';

    protected $fillable = [
        'order_id',
        'client_id',
        'handyman_id',
        'rating',
        'comment',
        'response',
        'response_at',
    ];

    protected $casts = [
        'rating' => 'integer',
        'response_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the order associated with this review.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    /**
     * Get the client who wrote this review.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    /**
     * Get the handyman being reviewed.
     */
    public function handyman(): BelongsTo
    {
        return $this->belongsTo(Handyman::class, 'handyman_id', 'handyman_id');
    }

    /**
     * Scope to get reviews with a minimum rating.
     */
    public function scopeMinRating($query, $rating)
    {
        return $query->where('rating', '>=', $rating);
    }

    /**
     * Scope to get recent reviews.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
