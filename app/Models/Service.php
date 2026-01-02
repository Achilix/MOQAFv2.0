<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'name_fr',
        'description',
        'icon',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all gigs for this service
     */
    public function gigs()
    {
        return $this->hasMany(Gig::class, 'service_id');
    }
}
