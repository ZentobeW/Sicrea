@component('mail::message')
# Permintaan Refund Baru

Peserta {{ $refund->transaction->registration->user->name }} mengajukan refund untuk event **{{ $refund->transaction->registration->event->title }}**.

Alasan:
> {{ $refund->reason ?? 'Tidak ada alasan yang diberikan.' }}

Segera proses melalui dashboard admin.

Terima kasih,
{{ config('app.name') }}
@endcomponent
