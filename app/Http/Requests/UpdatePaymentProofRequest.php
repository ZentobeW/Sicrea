<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentProofRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Registration $registration */
        $registration = $this->route('registration');

        return $registration && $this->user()?->can('update', $registration);
    }

    public function rules(): array
    {
        return [
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ];
    }
}
