<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'client';
    protected $primaryKey = 'client_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'client_id',
        'rating',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
    ];

    /**
     * Get the user that owns the client profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id', 'id');
    }

    /**
     * Get the orders for this client.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_client', 'client_id');
    }
}
