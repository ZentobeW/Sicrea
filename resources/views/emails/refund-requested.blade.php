@component('mail::message')
# Permintaan Refund Baru

Peserta {{ $refund->registration->user->name }} mengajukan refund untuk event **{{ $refund->registration->event->title }}**.

Alasan:
> {{ $refund->reason ?? 'Tidak ada alasan yang diberikan.' }}

Segera proses melalui dashboard admin.

Terima kasih,
{{ config('app.name') }}
@endcomponent
