<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'address',
        'city',
        'phone_number',
        'gov_id',
        'photo',
        'email',
        'password', // changed from password_hash
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password', // changed from password_hash
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // changed from password_hash
            'created_at' => 'datetime',
        ];
    }

    /**
     * Get the client profile associated with this user.
     */
    public function client(): HasOne
    {
        return $this->hasOne(Client::class, 'client_id', 'id');
    }

    /**
     * Get the handyman profile associated with this user.
     */
    public function handyman(): HasOne
    {
        return $this->hasOne(Handyman::class, 'handyman_id', 'id');
    }

    /**
     * Check if this user is a client.
     */
    public function isClient(): bool
    {
        return $this->client()->exists();
    }

    /**
     * Check if this user is a handyman.
     */
    public function isHandyman(): bool
    {
        return $this->handyman()->exists();
    }
}
