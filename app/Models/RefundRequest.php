<?php

namespace App\Models;

use App\Enums\RefundStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'status',
        'reason',
        'admin_note',
        'requested_at',
        'processed_at',
    ];

    protected $casts = [
        'status' => RefundStatus::class,
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
