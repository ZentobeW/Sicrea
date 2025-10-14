@component('mail::message')
# Bukti Pembayaran Baru

Peserta **{{ $registration->user->name }}** telah mengunggah bukti pembayaran untuk event **{{ $registration->event->title }}**.

- Email: {{ $registration->user->email }}
- Nominal: Rp{{ number_format($registration->amount, 0, ',', '.') }}
- Tanggal Daftar: {{ optional($registration->registered_at)->format('d-m-Y H:i') }}

Silakan lakukan verifikasi pada dashboard admin.

Terima kasih,
{{ config('app.name') }}
@endcomponent
