<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Attributes\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_at',
        'end_at',
        'venue_name',
        'venue_address',
        'tutor_name',
        'capacity',
        'available_slots',
        'price',
        'status',
        'published_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'published_at' => 'datetime',
        'status' => EventStatus::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (Event $event) {
            if ($event->capacity && $event->available_slots === null) {
                $event->available_slots = $event->capacity;
            }
        });
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function isPublished(): bool
    {
        return $this->status === EventStatus::Published;
    }

    public function titleWithSchedule(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf(
                '%s (%s - %s)',
                $this->title,
                $this->start_at?->translatedFormat('d M Y H:i'),
                $this->end_at?->translatedFormat('d M Y H:i')
            )
        );
    }
}
