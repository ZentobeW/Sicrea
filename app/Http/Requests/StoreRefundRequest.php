<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;

class StoreRefundRequest extends FormRequest
{
    public function authorize(): bool
    {
        $registration = $this->registration();

        return $this->user()?->can('requestRefund', $registration) ?? false;
    }

    public function rules(): array
    {
        return [
            'reason' => ['required', 'string', 'max:1000'],
        ];
    }

    public function registration(): Registration
    {
        $registration = $this->route('registration');

        if ($registration instanceof Registration) {
            return $registration->loadMissing('user');
        }

        return Registration::with('user')->findOrFail($registration);
    }
}
