<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Handyman extends Model
{
    use SoftDeletes;

    protected $table = 'handyman';
    protected $primaryKey = 'handyman_id';
    public $incrementing = false;

    protected $fillable = [
        'handyman_id',
        'services',
        'bio',
    ];

    protected $casts = [
        'services' => 'array',
    ];

    /**
     * Get the user that owns the handyman profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handyman_id', 'id');
    }

    /**
     * Get the gigs this handyman is associated with.
     */
    public function gigs(): BelongsToMany
    {
        return $this->belongsToMany(
            Gig::class,
            'handymangigs',
            'id_handyman',
            'id_gig',
            'handyman_id',
            'id_gig'
        );
    }

    /**
     * Get the orders for this handyman.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_handyman', 'handyman_id');
    }

    /**
     * Get the average rating from completed orders.
     */
    public function getAverageRatingAttribute()
    {
        return $this->orders()
            ->whereNotNull('rating')
            ->where('status', 'completed')
            ->avg('rating');
    }

    /**
     * Get the count of completed orders.
     */
    public function getCompletedJobsCountAttribute()
    {
        return $this->orders()
            ->where('status', 'completed')
            ->count();
    }

    /**
     * Get the reviews for this handyman.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'handyman_id', 'handyman_id');
    }

    /**
     * Get the average rating from reviews.
     */
    public function getAverageReviewRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }

    /**
     * Get the total review count.
     */
    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
