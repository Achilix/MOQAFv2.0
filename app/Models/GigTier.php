<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class GigTier extends Model
{
    use SoftDeletes;

    protected $table = 'gig_tiers';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_gig',
        'tier_name',
        'description',
        'base_price',
        'delivery_days',
        'created_at',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'delivery_days' => 'integer',
        'created_at' => 'datetime',
    ];

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    /**
     * Get the gig this tier belongs to
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class, 'id_gig', 'id_gig');
    }
}
