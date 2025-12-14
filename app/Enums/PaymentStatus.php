<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case Pending = 'pending';
    case AwaitingVerification = 'awaiting_verification';
    case Verified = 'verified';
    case Rejected = 'rejected';
    case Refunded = 'refunded';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Belum Dibayar',
            self::AwaitingVerification => 'Menunggu Verifikasi',
            self::Verified => 'Pembayaran Terverifikasi',
            self::Rejected => 'Ditolak',
            self::Refunded => 'Refund',
        };
    }
}
