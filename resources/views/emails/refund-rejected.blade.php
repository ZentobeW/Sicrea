@component('mail::message')
# Refund Ditolak

Halo {{ $refund->transaction->registration->user->name }},

Mohon maaf, permohonan refund kamu untuk event **{{ $refund->transaction->registration->event->title }}** belum dapat kami proses.
@if($refund->admin_note)
Alasan:
> {{ $refund->admin_note }}
@endif

Jika membutuhkan bantuan lebih lanjut silakan hubungi admin.

Terima kasih,
{{ config('app.name') }}
@endcomponent
