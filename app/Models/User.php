<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, MustVerifyEmail;

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
        'is_admin',
        'email_verified_at',
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
            'is_admin' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        // Prefer boolean flag; fallback to admin relation for older data
        if ($this->is_admin) {
            return true;
        }

        return $this->relationLoaded('admin')
            ? $this->admin !== null
            : $this->admin()->exists();
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
