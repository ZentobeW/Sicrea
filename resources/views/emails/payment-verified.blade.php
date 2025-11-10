@component('mail::message')
# Pembayaran Terverifikasi

Halo {{ $registration->user->name }},

Pembayaran kamu untuk event **{{ $registration->event->title }}** telah kami verifikasi.

Detail:
- Jadwal: {{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}
- Venue: {{ $registration->event->venue_name }}
- Alamat: {{ $registration->event->venue_address }}
- Tutor: {{ $registration->event->tutor_name }}
- Nominal: Rp{{ number_format($registration->amount, 0, ',', '.') }}

Sampai jumpa di acara!

Salam hangat,
{{ config('app.name') }}
@endcomponent
