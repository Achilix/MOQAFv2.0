<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false; // Table only has created_at

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_client',
        'id_handyman',
        'id_gig',
        'price',
        'description',
        'rating',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'rating' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the client associated with this order.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client', 'client_id');
    }

    /**
     * Get the handyman associated with this order.
     */
    public function handyman(): BelongsTo
    {
        return $this->belongsTo(Handyman::class, 'id_handyman', 'handyman_id');
    }

    /**
     * Get the gig associated with this order.
     */
    public function gig(): BelongsTo
    {
        return $this->belongsTo(Gig::class, 'id_gig', 'id_gig');
    }
}
