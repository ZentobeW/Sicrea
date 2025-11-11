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
        return $registration->user_id === $user->id;
    }

    public function update(User $user, Registration $registration): bool
    {
        return $registration->user_id === $user->id;
    }

    public function requestRefund(User $user, Registration $registration): bool
    {
        $transaction = $registration->transaction;

        return $registration->user_id === $user->id
            && $transaction
            && $transaction->status === PaymentStatus::Verified;
    }
}
