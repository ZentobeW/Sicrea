<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
        'payment_status',
        'amount',
        'payment_proof_path',
        'form_data',
        'registered_at',
        'paid_at',
        'verified_at',
    ];

    protected $casts = [
        'form_data' => 'array',
        'registered_at' => 'datetime',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'status' => RegistrationStatus::class,
        'payment_status' => PaymentStatus::class,
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function refundRequest(): HasOne
    {
        return $this->hasOne(RefundRequest::class);
    }

    public function markVerified(): void
    {
        $this->update([
            'status' => RegistrationStatus::Confirmed,
            'payment_status' => PaymentStatus::Verified,
            'verified_at' => now(),
        ]);
    }
}
