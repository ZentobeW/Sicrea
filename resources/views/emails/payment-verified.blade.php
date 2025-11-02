@component('mail::message')
# Pembayaran Terverifikasi

Halo {{ $registration->user->name }},

Pembayaran kamu untuk event **{{ $registration->event->title }}** telah kami verifikasi.

Detail:
- Jadwal: {{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}
- Lokasi: {{ $registration->event->location }}
- Nominal: Rp{{ number_format($registration->amount, 0, ',', '.') }}

Sampai jumpa di acara!

Salam hangat,
{{ config('app.name') }}
@endcomponent
