<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user1_id',
        'user2_id',
    ];

    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /**
     * Get the first user in the conversation.
     */
    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id', 'id');
    }

    /**
     * Get the second user in the conversation.
     */
    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id', 'id');
    }

    /**
     * Get all messages in this conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}

