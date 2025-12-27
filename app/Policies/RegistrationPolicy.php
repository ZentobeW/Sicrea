<?php

namespace App\Policies;

use App\Enums\PaymentStatus;
use App\Models\Registration;
use App\Models\User;

class RegistrationPolicy
{
    public function before(?User $user, string $ability)
    {
        if ($user?->isAdmin()) {
            return true;
        }

        return null;
    }

    public function view(User $user, Registration $registration): bool
    {
        return (int) $registration->user_id === (int) $user->getAuthIdentifier();
    }

    public function update(User $user, Registration $registration): bool
    {
        return (int) $registration->user_id === (int) $user->getAuthIdentifier();
    }

    public function requestRefund(User $user, Registration $registration): bool
    {
        $transaction = $registration->transaction;

        return (int) $registration->user_id === (int) $user->getAuthIdentifier()
            && $transaction
            && $transaction->status === PaymentStatus::Verified;
    }
}
