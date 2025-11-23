<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'province',
        'city',
        'address',
        'avatar_path',
        'password',
        'google_id',
        'oauth_provider',
        'is_admin', // Added admin attribute
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'is_admin' => 'boolean', // Added admin cast
        ];
    }

    // Added isAdmin() method
    public function isAdmin(): bool
    {
        return (bool) $this->is_admin;
    }

    // Added registrations relationship
    public function registrations()
    {
        return $this->hasMany(\App\Models\Registration::class);
    }

    // Added admin relationship
    public function admin()
    {
        return $this->hasOne(\App\Models\Admin::class);
    }
}
