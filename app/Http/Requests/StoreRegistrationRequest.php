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
            'form_data.account_number' => [
                'required', 
                'string',
                 function ($attribute, $value, $fail) {
                    $bank = $this->input('form_data.bank_name');
                    $rules = [
                        'BRI'                  => 15,
                        'BCA'                  => 10,
                        'BNI'                  => 10,
                        'Bank Mandiri'         => 13,
                        'BTN'                  => 16,
                        'BSI'                  => 10,
                        'Bank Danamon'         => 10,
                        'Bank Bukopin'         => 10,
                        'OCBC NISP'            => 12,
                        'Bank CIMB Niaga'      => 13,
                        'Bank Muamalat'        => 10,
                        'Bank Sinarmas Syariah'=> 10,
                    ];

                    if (!ctype_digit($value)) {
                        return $fail('Nomor rekening harus berupa angka.');
                    }

                    if (isset($rules[$bank])) {
                        if (strlen($value) !== $rules[$bank]) {
                            return $fail("Nomor rekening {$bank} harus {$rules[$bank]} digit.");
                        }
                        return;
                    }

                    $length = strlen($value);
                    if ($length < 8 || $length > 20) {
                        return $fail('Nomor rekening harus 8–20 digit.');
                    }
                }
            ],
            'form_data.company' => ['nullable', 'string', 'max:255'],
        ];
    }
}
