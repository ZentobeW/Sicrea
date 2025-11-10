@component('mail::message')
# Pendaftaran Diterima

Selamat {{ $registration->user->name }},

Pendaftaran kamu untuk event **{{ $registration->event->title }}** telah kami terima.

Silakan hadir sesuai jadwal di bawah ini:
- Tanggal: {{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}
- Venue: {{ $registration->event->venue_name }}
- Alamat: {{ $registration->event->venue_address }}
- Tutor: {{ $registration->event->tutor_name }}

Jika membutuhkan bantuan, hubungi kami melalui email ini.

Terima kasih,
{{ config('app.name') }}
@endcomponent
