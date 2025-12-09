<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;

/**
 * Password reset notification; dikirim langsung tanpa antrean.
 */
class QueuedResetPassword extends ResetPassword
{
}
