<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'form_data',
        'registered_at',
        'notes',
    ];

    protected $appends = [
        'payment_status',
        'amount',
        'payment_proof_path',
        'paid_at',
        'verified_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'registered_at' => 'datetime',
        'status' => RegistrationStatus::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    public function refund(): HasOneThrough
    {
        return $this->hasOneThrough(Refund::class, Transaction::class);
    }

    public function emails()
    {
        return $this->hasMany(\App\Models\Email::class);
    }

    public function markVerified(): void
    {
        $this->update([
            'status' => RegistrationStatus::Confirmed,
        ]);

        $this->transaction?->update([
            'status' => \App\Enums\PaymentStatus::Verified,
            'verified_at' => now(),
        ]);
    }

    protected function paymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transaction?->status,
        );
    }

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transaction?->amount,
        );
    }

    protected function paymentProofPath(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transaction?->payment_proof_path,
        );
    }

    protected function paidAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transaction?->paid_at,
        );
    }

    protected function verifiedAt(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->transaction?->verified_at,
        );
    }
}
