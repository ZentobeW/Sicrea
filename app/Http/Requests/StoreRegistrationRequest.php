<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var Event $event */
        $event = $this->route('event');

        return $event && $event->isPublished() && $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'form_data' => ['required', 'array'],
            'form_data.name' => ['required', 'string', 'max:255'],
            'form_data.email' => ['required', 'email'],
            'form_data.phone' => ['required', 'string', 'max:25'],
            'form_data.bank_name' => ['required', 'string', 'max:100'],
            'form_data.account_number' => ['required', 'string', 'max:30'],
            'form_data.company' => ['nullable', 'string', 'max:255'],
        ];
    }
}
