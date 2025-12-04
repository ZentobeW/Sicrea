<?php

namespace App\Models;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Attributes\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function remainingSlots(): ?int
    {
        if (! $this->capacity) {
            return null;
        }

        $confirmedOrHeld = $this->registrations()
            ->where(function ($query) {
                $query->where('status', RegistrationStatus::Confirmed->value)
                    ->orWhereHas('transaction', function ($transactionQuery) {
                        $transactionQuery->whereIn('status', [
                            PaymentStatus::Pending->value,
                            PaymentStatus::AwaitingVerification->value,
                            PaymentStatus::Verified->value,
                        ]);
                    });
            })
            ->count();

        return max($this->capacity - $confirmedOrHeld, 0);
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
