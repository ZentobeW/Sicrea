@component('mail::message')
# Pendaftaran Diterima

Selamat {{ $registration->user->name }},

Pendaftaran kamu untuk event **{{ $registration->event->title }}** telah kami terima.

Silakan hadir sesuai jadwal di bawah ini:
- Tanggal: {{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}
- Lokasi: {{ $registration->event->location }}

Jika membutuhkan bantuan, hubungi kami melalui email ini.

Terima kasih,
{{ config('app.name') }}
@endcomponent
