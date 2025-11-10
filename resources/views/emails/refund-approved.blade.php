@component('mail::message')
# Refund Disetujui

Halo {{ $refund->transaction->registration->user->name }},

Permohonan refund untuk event **{{ $refund->transaction->registration->event->title }}** telah kami setujui. Dana akan dikembalikan maksimal 3 hari kerja.

Terima kasih telah mengikuti kegiatan kami.

Salam,
{{ config('app.name') }}
@endcomponent
