<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('event')) ?? false;
    }

    public function rules(): array
    {
        $eventId = $this->route('event')->id ?? null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:events,slug,' . $eventId],
            'description' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after_or_equal:start_at'],
            'location' => ['required', 'string', 'max:255'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'available_slots' => ['nullable', 'integer', 'min:0'],
            'price' => ['required', 'integer', 'min:0'],
            'publish' => ['nullable', 'boolean'],
        ];
    }
}
