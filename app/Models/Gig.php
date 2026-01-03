<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Gig extends Model
{
    use SoftDeletes;

    protected $table = 'gigs';
    protected $primaryKey = 'id_gig';
    public $timestamps = false;

    protected $fillable = [
        'title',
        'type',
        'service_id',
        'description',
        'photos',
        'price',
        'duration',
        'location',
        'availability',
    ];

    protected $casts = [
        'photos' => 'array',
        'created_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    /**
     * Get the handymen associated with this gig.
     */
    public function handymen(): BelongsToMany
    {
        return $this->belongsToMany(
            Handyman::class,
            'handymangigs',
            'id_gig',
            'id_handyman',
            'id_gig',
            'handyman_id'
        );
    }

    /**
     * Get the orders for this gig.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_gig', 'id_gig');
    }

    /**
     * Get the service this gig belongs to
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the categories this gig belongs to.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'gig_category',
            'gig_id',
            'category_id',
            'id_gig',
            'category_id'
        );
    }

    /**
     * Get the reviews through orders.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'gig_id', 'id_gig');
    }

    /**
     * Get the pricing tiers for this gig.
     */
    public function tiers(): HasMany
    {
        return $this->hasMany(GigTier::class, 'id_gig', 'id_gig');
    }
}
