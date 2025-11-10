<x-layouts.app :title="'Profil Saya'">
    @php
        $avatarUrl = $user->avatar_path
            ? Storage::disk('public')->url($user->avatar_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFE1D0&color=7C3A2D';
    @endphp

    <section class="bg-gradient-to-b from-[#FFF2E7] via-[#FFE2CF] to-[#F8C0A7] py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            {{-- Header Profil --}}
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-[#D97862]">Area Pengguna</p>
                    <h1 class="mt-2 text-4xl font-semibold text-[#7C3A2D]">Profil Saya</h1>
                    <p class="mt-2 text-sm text-[#9A5A46]">Kelola data pribadi, pantau status pendaftaran, dan lihat aktivitas workshop terbaru.</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-white/80 px-5 py-2.5 text-sm font-semibold text-[#7C3A2D] shadow-lg shadow-[#F4B59E]/30 transition hover:bg-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Profil
                </a>
            </div>

            {{-- Statistik --}}
            <div class="grid gap-5 md:grid-cols-2">
                <div class="rounded-3xl bg-white/90 p-6 shadow-lg ring-1 ring-[#F7C8B8]/60">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-[#D97862]">Status Pendaftaran</p>
                            <h2 class="mt-2 text-2xl font-semibold text-[#7C3A2D]">{{ $pendingRegistrations }} Pendaftaran</h2>
                            <p class="mt-2 text-sm text-[#9A5A46]">Menunggu konfirmasi admin. Kami akan mengabari saat pembayaran terverifikasi.</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#FFE4D6] text-[#D97862]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="rounded-3xl bg-white/90 p-6 shadow-lg ring-1 ring-[#F7C8B8]/60">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-xs uppercase tracking-[0.3em] text-[#D97862]">Status Refund</p>
                            <h2 class="mt-2 text-2xl font-semibold text-[#7C3A2D]">{{ $activeRefunds }} Permohonan</h2>
                            <p class="mt-2 text-sm text-[#9A5A46]">Sedang diproses oleh tim keuangan (estimasi 3–5 hari kerja).</p>
                        </div>
                        <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#FFE4D6] text-[#D97862]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 12A8.25 8.25 0 0112 3.75v0A8.25 8.25 0 0120.25 12v0A8.25 8.25 0 0112 20.25v0A8.25 8.25 0 013.75 12z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Informasi Pribadi & Event --}}
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                {{-- Info Pribadi --}}
                <div class="rounded-3xl bg-white/90 p-8 shadow-xl ring-1 ring-[#F7C8B8]/60">
                    <div class="flex items-center gap-4">
                        <img src="{{ $avatarUrl }}" alt="Avatar {{ $user->name }}" class="h-24 w-24 rounded-full border-4 border-white object-cover shadow-lg">
                        <div>
                            <h2 class="text-2xl font-semibold text-[#7C3A2D]">{{ $user->name }}</h2>
                            <p class="text-sm text-[#9A5A46]">{{ $user->email }}</p>
                            @if ($user->phone)
                                <p class="text-sm text-[#9A5A46] mt-1">{{ $user->phone }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl bg-[#FFF5EF] p-4">
                            <p class="text-xs uppercase text-[#D97862]">Tanggal Lahir</p>
                            <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ optional($user->birth_date)->translatedFormat('d F Y') ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-4">
                            <p class="text-xs uppercase text-[#D97862]">Provinsi</p>
                            <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ $user->province ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-4">
                            <p class="text-xs uppercase text-[#D97862]">Kabupaten/Kota</p>
                            <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ $user->city ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-4">
                            <p class="text-xs uppercase text-[#D97862]">Alamat</p>
                            <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ $user->address ?? 'Belum diisi' }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tiket Event --}}
                <div class="rounded-3xl bg-white/90 p-8 shadow-xl ring-1 ring-[#F7C8B8]/60">
                    <h2 class="text-2xl font-semibold text-[#7C3A2D]">Tiket Event</h2>
                    <p class="mt-2 text-sm text-[#9A5A46]">Event yang akan kamu ikuti.</p>

                    @if ($upcomingRegistration)
                        <div class="mt-6 rounded-2xl bg-[#FFF1EC] p-5 shadow-inner">
                            <p class="text-xs uppercase text-[#D97862]">Event Berikutnya</p>
                            <h3 class="mt-3 text-lg font-semibold text-[#7C3A2D]">{{ $upcomingRegistration->event->title }}</h3>
                            <dl class="mt-4 space-y-2 text-sm text-[#9A5A46]">
                                <div class="flex justify-between"><dt>Tanggal</dt>
                                    <dd>{{ optional($upcomingRegistration->event->start_at)->translatedFormat('d F Y, H:i') }}</dd></div>
                                <div class="flex justify-between"><dt>Venue</dt>
                                    <dd class="text-right">
                                        <span class="block font-semibold text-[#7C3A2D]">{{ $upcomingRegistration->event->venue_name }}</span>
                                        <span class="block text-xs text-[#9A5A46]">{{ $upcomingRegistration->event->venue_address }}</span>
                                    </dd></div>
                                <div class="flex justify-between"><dt>Pemateri</dt>
                                    <dd>{{ $upcomingRegistration->event->tutor_name }}</dd></div>
                                <div class="flex justify-between"><dt>Status Pembayaran</dt>
                                    <dd class="font-semibold text-[#7C3A2D]">{{ $upcomingRegistration->transaction?->status->label() ?? 'Belum Dibuat' }}</dd></div>
                            </dl>
                        </div>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-[#F7C8B8] p-6 text-sm text-[#9A5A46]">
                            Belum ada event terjadwal. Yuk lihat <a href="{{ route('events.index') }}" class="font-semibold text-[#D97862]">daftar event</a>!
                        </div>
                    @endif
                </div>
            </div>

            {{-- Riwayat Aktivitas --}}
            <div class="rounded-3xl bg-white/90 p-8 shadow-xl ring-1 ring-[#F7C8B8]/60">
                <h2 class="text-2xl font-semibold text-[#7C3A2D] mb-2">Riwayat Aktivitas</h2>
                <p class="text-sm text-[#9A5A46] mb-4">Pantau status pendaftaran dan refund terbaru.</p>

                <div class="overflow-hidden rounded-2xl border border-[#F7C8B8]/80">
                    <table class="min-w-full divide-y divide-[#F7C8B8] text-sm">
                        <thead class="bg-[#FFEDE0] text-[#7C3A2D]">
                            <tr>
                                <th class="px-6 py-3 text-left font-semibold">Event</th>
                                <th class="px-6 py-3 text-left font-semibold">Pendaftaran</th>
                                <th class="px-6 py-3 text-left font-semibold">Pembayaran</th>
                                <th class="px-6 py-3 text-left font-semibold">Refund</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F7C8B8]/60 bg-white">
                            @forelse ($recentRegistrations as $registration)
                                @php
                                    $transaction = $registration->transaction;
                                    $registrationBadge = match ($registration->status) {
                                        \App\Enums\RegistrationStatus::Pending => 'bg-[#FFF1EC] text-[#D97862]',
                                        \App\Enums\RegistrationStatus::Confirmed => 'bg-[#E9F6EC] text-[#2F7A48]',
                                        \App\Enums\RegistrationStatus::Cancelled => 'bg-[#FFE5E5] text-[#B85454]',
                                        \App\Enums\RegistrationStatus::Refunded => 'bg-[#E8F3FF] text-[#2B6CB0]',
                                    };
                                    $paymentBadge = match ($transaction?->status) {
                                        \App\Enums\PaymentStatus::Pending => 'bg-[#FFF1EC] text-[#D97862]',
                                        \App\Enums\PaymentStatus::AwaitingVerification => 'bg-[#FDF7D8] text-[#B89530]',
                                        \App\Enums\PaymentStatus::Verified => 'bg-[#E9F6EC] text-[#2F7A48]',
                                        \App\Enums\PaymentStatus::Rejected => 'bg-[#FFE5E5] text-[#B85454]',
                                        \App\Enums\PaymentStatus::Refunded => 'bg-[#E8F3FF] text-[#2B6CB0]',
                                        default => 'bg-[#EFEFEF] text-[#7C3A2D]',
                                    };
                                    $refundStatus = $transaction?->refund?->status;
                                    $refundBadge = $refundStatus ? match ($refundStatus) {
                                        \App\Enums\RefundStatus::Pending => 'bg-[#FDF7D8] text-[#B89530]',
                                        \App\Enums\RefundStatus::Approved => 'bg-[#E9F6EC] text-[#2F7A48]',
                                        \App\Enums\RefundStatus::Rejected => 'bg-[#FFE5E5] text-[#B85454]',
                                        \App\Enums\RefundStatus::Completed => 'bg-[#E8F3FF] text-[#2B6CB0]',
                                    } : null;
                                @endphp
                                <tr class="text-[#7C3A2D]">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold">{{ $registration->event->title }}</div>
                                        <div class="text-xs text-[#9A5A46] mt-1">{{ optional($registration->registered_at)->translatedFormat('d F Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $registrationBadge }}">
                                            {{ $registration->status->label() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $paymentBadge }}">
                                            {{ $transaction?->status->label() ?? 'Belum Dibuat' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($refundStatus)
                                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $refundBadge }}">
                                                {{ $transaction->refund->status->label() }}
                                            </span>
                                        @else
                                            <span class="text-xs text-[#C99F92]">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-[#9A5A46]">
                                        Belum ada aktivitas yang tercatat. Mulai dengan mendaftar workshop favoritmu!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
