@php
    use Illuminate\Support\Facades\Storage;
@endphp
<x-layouts.app :title="'Profil Saya'">
    @php
        $avatarUrl = $user->avatar_path
            ? Storage::disk('public')->url($user->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFE1D0&color=7C3A2D';
        $isRefundView = request('tab') === 'refund';
    @endphp

    {{-- Custom Style --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, th, td, button {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover {
            transform: scale(1.05);
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            border-color: #822021 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-8 sm:py-12 lg:py-16 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-5 lg:space-y-6">
            
            {{-- Header Profil --}}
            <div class="flex items-center justify-between">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#822021]">Profil Saya</h1>
                
                {{-- Button Edit Profil --}}
                <a href="{{ route('profile.edit') }}"
                    class="btn-action inline-flex items-center gap-2 rounded-full bg-[#FAF8F1] border border-[#822021] px-5 py-2.5 text-sm font-semibold text-[#822021] shadow-md whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Profil
                </a>
            </div>
            <p class="mt-0.5 text-sm text-[#822021]/70">Kelola data pribadi, pantau status pendaftaran, dan lihat aktivitas workshop terbaru.</p>

            {{-- Stats Cards --}}
            <div class="grid gap-4 sm:gap-5 md:grid-cols-2">
                {{-- Card 1: Pendaftaran --}}
                <div class="rounded-3xl bg-[#FAF8F1] border border-[#822021] p-4 sm:p-6 shadow-lg shadow-[#822021]/10 relative">
                    <span class="absolute top-4 right-4 inline-flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-[#FFDEF8] text-[#822021] border border-[#822021]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div class="pr-16">
                        <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Status Pendaftaran</p>
                        <h2 class="mt-2 text-xl sm:text-2xl font-bold text-[#822021]">{{ $pendingRegistrations }} Pendaftaran</h2>
                        <p class="mt-2 text-sm text-[#822021]/70">Menunggu konfirmasi admin. Admin akan segera memverifikasi Pembayaran Anda.</p>
                    </div>
                </div>
                
                {{-- Card 2: Refund --}}
                <div class="rounded-3xl bg-[#FAF8F1] border border-[#822021] p-4 sm:p-6 shadow-lg shadow-[#822021]/10 relative">
                    <span class="absolute top-4 right-4 inline-flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-[#FFDEF8] text-[#822021] border border-[#822021]/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </span>
                    <div class="pr-16">
                        <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Status Refund</p>
                        <h2 class="mt-2 text-xl sm:text-2xl font-bold text-[#822021]">{{ $activeRefunds }} Permohonan</h2>
                        <p class="mt-2 text-sm text-[#822021]/70">Sedang diproses. Estimasi penyelesaian 1–3 hari kerja.</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                {{-- Left Column: Biodata --}}
                <div class="rounded-3xl bg-[#FAF8F1] border border-[#822021] p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#822021]/10">
                    <div class="flex flex-col gap-4 sm:gap-6 lg:flex-row lg:items-center">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <img src="{{ $avatarUrl }}" alt="Avatar {{ $user->name }}" class="h-20 w-20 sm:h-24 sm:w-24 rounded-full border-4 border-[#FFDEF8] object-cover shadow-lg">
                            <div class="text-center sm:text-left">
                                <h2 class="text-xl sm:text-2xl font-bold text-[#822021]">{{ $user->name }}</h2>
                                <p class="text-sm text-[#822021]/70 break-all">{{ $user->email }}</p>
                                @if ($user->phone)
                                    <p class="text-sm text-[#822021]/70 mt-1">{{ $user->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2">
                        <div class="rounded-2xl bg-[#FFDEF8] border border-[#822021]/10 p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Tanggal Lahir</p>
                            <p class="mt-2 text-sm font-bold text-[#822021] break-words">{{ optional($user->birth_date)->translatedFormat('d F Y') ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFDEF8] border border-[#822021]/10 p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Provinsi</p>
                            <p class="mt-2 text-sm font-bold text-[#822021] break-words">{{ $user->province ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFDEF8] border border-[#822021]/10 p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Kabupaten/Kota</p>
                            <p class="mt-2 text-sm font-bold text-[#822021] break-words">{{ $user->city ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFDEF8] border border-[#822021]/10 p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Alamat</p>
                            <p class="mt-2 text-sm font-bold text-[#822021] break-words">{{ $user->address ?? 'Belum diisi' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Right Column: Tiket Selanjutnya --}}
                <div class="rounded-3xl bg-[#FAF8F1] border border-[#822021] p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#822021]/10">
                    <h2 class="text-xl sm:text-2xl font-bold text-[#822021]">Tiket Event</h2>
                    <p class="mt-2 text-sm text-[#822021]/70">Detail event yang akan kamu ikuti selanjutnya.</p>

                    @if ($upcomingRegistration)
                        <div class="mt-6 rounded-2xl bg-[#FFDEF8] border border-[#822021]/20 p-5 shadow-inner">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#822021]/60 font-semibold">Event Berikutnya</p>
                            <h3 class="mt-3 text-lg font-bold text-[#822021]">{{ $upcomingRegistration->event->title }}</h3>
                            <dl class="mt-4 space-y-2 text-sm text-[#822021]/80">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-semibold">Tanggal</dt>
                                    <dd class="sm:text-right">{{ optional($upcomingRegistration->event->start_at)->translatedFormat('d F Y, H:i') }}</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-semibold">Lokasi</dt>
                                    <dd class="sm:text-right break-words">{{ $upcomingRegistration->event->location }}</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-semibold">Status Pembayaran</dt>
                                    <dd class="font-bold text-[#822021] sm:text-right">{{ $upcomingRegistration->payment_status->label() }}</dd>
                                </div>
                            </dl>
                            <a href="{{ route('registrations.show', $upcomingRegistration) }}"
                                class="btn-action mt-5 inline-flex items-center gap-2 rounded-full border border-[#822021] bg-[#FAF8F1] px-4 py-2 text-sm font-bold text-[#822021] shadow-sm">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-[#822021]/40 p-6 text-sm text-[#822021]/60 text-center bg-[#FFDEF8]/50">
                            Belum ada event terjadwal. Yuk jelajahi <a href="{{ route('events.index') }}" class="font-bold text-[#822021] underline decoration-[#822021]/30 hover:decoration-[#822021]">daftar event</a> dan amankan tempatmu!
                        </div>
                    @endif
                </div>
            </div>

            {{-- History Section --}}
            <div class="rounded-3xl bg-[#FAF8F1] border border-[#822021] p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#822021]/10">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-bold text-[#822021]">Riwayat Aktivitas</h2>
                        <p class="text-sm text-[#822021]/70">Pantau perkembangan pendaftaran, status pembayaran, dan refund terbaru.</p>
                    </div>
                    
                    {{-- Tabs --}}
                    <div class="inline-flex rounded-full bg-[#FFDEF8] border border-[#822021]/20 p-1 text-sm font-semibold w-full sm:w-auto">
                        <a href="{{ route('profile.show') }}"
                            @class([
                                'rounded-full px-3 sm:px-4 py-2 transition flex-1 sm:flex-none text-center',
                                'bg-[#822021] text-[#FCF5E6] shadow-md' => ! $isRefundView,
                                'text-[#822021] hover:bg-[#822021]/10' => $isRefundView,
                            ])>
                            Pendaftaran
                        </a>
                        <a href="{{ route('profile.show', ['tab' => 'refund']) }}"
                            @class([
                                'rounded-full px-3 sm:px-4 py-2 transition flex-1 sm:flex-none text-center',
                                'bg-[#822021] text-[#FCF5E6] shadow-md' => $isRefundView,
                                'text-[#822021] hover:bg-[#822021]/10' => ! $isRefundView,
                            ])>
                            Refund
                        </a>
                    </div>
                </div>

                @if (! $isRefundView)
                    {{-- TABEL PENDAFTARAN --}}
                    <div class="mt-6 overflow-x-auto rounded-2xl border border-[#822021]">
                        <table class="min-w-full divide-y divide-[#822021]/20 text-sm">
                            <thead class="bg-[#822021] text-[#FCF5E6]">
                                <tr>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Event</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden sm:table-cell">Tanggal</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Total</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Status</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#822021]/10 bg-white">
                                @forelse ($recentRegistrations as $registration)
                                    @php
                                        $paymentBadge = match ($registration->payment_status) {
                                            \App\Enums\PaymentStatus::Pending => 'bg-[#FFF1EC] text-[#D97862]',
                                            \App\Enums\PaymentStatus::AwaitingVerification => 'bg-[#FDF7D8] text-[#B89530]',
                                            \App\Enums\PaymentStatus::Verified => 'bg-[#E9F6EC] text-[#2F7A48]',
                                            \App\Enums\PaymentStatus::Rejected => 'bg-[#FFE5E5] text-[#B85454]',
                                            \App\Enums\PaymentStatus::Refunded => 'bg-[#E8F3FF] text-[#2B6CB0]',
                                        };
                                    @endphp
                                    <tr class="text-[#822021] hover:bg-[#FFDEF8]/30 transition">
                                        <td class="px-3 sm:px-6 py-4 align-top">
                                            <div class="font-bold text-sm break-words">{{ $registration->event->title }}</div>
                                            <div class="text-[11px] text-[#822021]/60">ID: reg{{ $registration->id }}</div>
                                            <div class="text-xs text-[#822021]/60 sm:hidden mt-1">
                                                {{ optional($registration->registered_at)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#822021]/70 hidden sm:table-cell text-center">
                                            {{ optional($registration->registered_at)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top font-bold text-[#822021] text-sm text-center">
                                            Rp{{ number_format($registration->transaction?->amount ?? $registration->event->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <span class="inline-flex items-center rounded-full px-2 sm:px-3 py-1 text-xs font-bold border border-[#822021]/10 {{ $paymentBadge }}">
                                                {{ $registration->payment_status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <a href="{{ route('registrations.show', $registration) }}"
                                                class="btn-action inline-flex items-center gap-1 sm:gap-2 rounded-full bg-[#FFDEF8] border border-[#822021] px-3 sm:px-4 py-2 text-xs font-bold text-[#822021] shadow-sm whitespace-nowrap">
                                                <span class="hidden sm:inline">Lihat Tiket</span>
                                                <span class="sm:hidden">Tiket</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 sm:px-6 py-8 text-center text-sm text-[#822021]/60 italic">
                                            Belum ada aktivitas pendaftaran. Mulai dengan mendaftar workshop favoritmu!
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($recentRegistrations->hasPages())
                        <div class="mt-4 px-3 sm:px-6">
                            {{ $recentRegistrations->appends(request()->query())->links() }}
                        </div>
                    @endif
                @else
                    {{-- TABEL REFUND --}}
                    <div class="mt-6 overflow-x-auto rounded-2xl border border-[#822021]">
                        <table class="min-w-full divide-y divide-[#822021]/20 text-sm">
                            <thead class="bg-[#822021] text-[#FCF5E6]">
                                <tr>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Event</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden lg:table-cell">No. Rekening</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Jumlah</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden sm:table-cell">Tanggal</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Status</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#822021]/10 bg-white">
                                @forelse ($recentRefunds as $refund)
                                    @php
                                        $registration = $refund->transaction->registration;
                                        $statusClass = match ($refund->status) {
                                            \App\Enums\RefundStatus::Pending => 'bg-[#FDF7D8] text-[#B89530]',
                                            \App\Enums\RefundStatus::Approved => 'bg-[#E9F6EC] text-[#2F7A48]',
                                            \App\Enums\RefundStatus::Rejected => 'bg-[#FFE5E5] text-[#B85454]',
                                            \App\Enums\RefundStatus::Completed => 'bg-[#E8F3FF] text-[#2B6CB0]',
                                        };
                                    @endphp
                                    <tr class="text-[#822021] hover:bg-[#FFDEF8]/30 transition">
                                        <td class="px-3 sm:px-6 py-4 align-top">
                                            <div class="font-bold text-sm break-words">{{ $registration->event->title }}</div>
                                            <div class="text-[11px] text-[#822021]/60">ID: ref{{ $refund->id }}</div>
                                            <div class="text-xs text-[#822021]/60 sm:hidden lg:hidden mt-1">
                                                {{ data_get($registration->form_data, 'account_number', '-') }}
                                            </div>
                                            <div class="text-xs text-[#822021]/60 sm:hidden mt-1">
                                                {{ optional($refund->requested_at)->translatedFormat('d M Y') ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#822021]/70 hidden lg:table-cell text-center">
                                            {{ data_get($registration->form_data, 'account_number', '-') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top font-bold text-[#822021] text-sm text-center">
                                            Rp{{ number_format($refund->transaction->amount ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#822021]/70 hidden sm:table-cell text-center">
                                            {{ optional($refund->requested_at)->translatedFormat('d F Y') ?? '-' }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <span class="inline-flex items-center rounded-full px-2 sm:px-3 py-1 text-xs font-bold border border-[#822021]/10 {{ $statusClass }}">
                                                {{ $refund->status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <a href="{{ route('registrations.show', $registration) }}"
                                                class="btn-action inline-flex items-center gap-1 sm:gap-2 rounded-full bg-[#FFDEF8] border border-[#822021] px-3 sm:px-4 py-2 text-xs font-bold text-[#822021] shadow-sm whitespace-nowrap">
                                                <span class="hidden sm:inline">Lihat Tiket</span>
                                                <span class="sm:hidden">Tiket</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 sm:px-6 py-8 text-center text-sm text-[#822021]/60 italic">
                                            Belum ada data refund. Ajukan refund dari tiket yang sudah terverifikasi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($recentRefunds->hasPages())
                        <div class="mt-4 px-3 sm:px-6">
                            {{ $recentRefunds->appends(request()->query())->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>