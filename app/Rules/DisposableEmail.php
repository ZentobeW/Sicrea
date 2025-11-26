<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DisposableEmail implements ValidationRule
{
    /**
     * Basic blocklist to prevent temporary domains.
     */
    protected array $blockedDomains = [
        'mailinator.com',
        '10minutemail.com',
        'guerrillamail.com',
        'temp-mail.org',
        'yopmail.com',
        'getnada.com',
        'trashmail.com',
        'fakemail.net',
        'dispostable.com',
    ];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $domain = strtolower(substr(strrchr((string) $value, '@') ?: '', 1));

        if ($domain && in_array($domain, $this->blockedDomains, true)) {
            $fail('Email yang digunakan tidak diperbolehkan.');
        }
    }
}
