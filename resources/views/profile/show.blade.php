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

    <section class="relative overflow-hidden bg-gradient-to-br from-[#FFBE8E] to-[#FCF5E6] py-8 sm:py-12 lg:py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 sm:space-y-5 lg:space-y-6">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-semibold text-[#822021] font-['Cousine']">Profil Saya</h1>
                <a href="{{ route('profile.edit') }}"
                    class="inline-flex items-center gap-2 rounded-full bg-white/80 px-5 py-2.5 text-sm font-semibold text-[#822021] shadow-lg shadow-[#F4B59E]/30 transition hover:bg-white whitespace-nowrap font-['Open_Sans']">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L16.875 4.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    Edit Profil
                </a>
            </div>
            <p class="mt-0.5 text-sm text-[#B49F9A] font-['Open_Sans']">Kelola data pribadi, pantau status pendaftaran, dan lihat aktivitas workshop terbaru.</p>

            <div class="grid gap-4 sm:gap-5 md:grid-cols-2">
                <div class="rounded-3xl bg-white/90 p-4 sm:p-6 shadow-lg shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60 relative">
                    <span class="absolute top-4 right-4 inline-flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-[#FFE4D6] text-[#D97862]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </span>
                    <div class="pr-16">
                        <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Notifikasi Status Pendaftaran</p>
                        <h2 class="mt-2 text-xl sm:text-2xl font-semibold text-[#822021] font-['Cousine']">{{ $pendingRegistrations }} Pendaftaran</h2>
                        <p class="mt-2 text-sm text-[#B49F9A] font-['Open_Sans']">Menunggu konfirmasi admin. Admin akan segera memverifikasi Pembayaran Anda.</p>
                    </div>
                </div>
                <div class="rounded-3xl bg-white/90 p-4 sm:p-6 shadow-lg shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60 relative">
                    <span class="absolute top-4 right-4 inline-flex h-10 w-10 sm:h-12 sm:w-12 items-center justify-center rounded-full bg-[#FFE4D6] text-[#D97862]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                        </svg>
                    </span>
                    <div class="pr-16">
                        <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Notifikasi Status Refund</p>
                        <h2 class="mt-2 text-xl sm:text-2xl font-semibold text-[#822021] font-['Cousine']">{{ $activeRefunds }} Permohonan</h2>
                        <p class="mt-2 text-sm text-[#B49F9A] font-['Open_Sans']">Sedang diproses. Estimasi penyelesaian 1–3 hari kerja.</p>
                    </div>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
                <div class="rounded-3xl bg-white/90 p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60">
                    <div class="flex flex-col gap-4 sm:gap-6 lg:flex-row lg:items-center">
                        <div class="flex flex-col sm:flex-row items-center gap-4">
                            <img src="{{ $avatarUrl }}" alt="Avatar {{ $user->name }}" class="h-20 w-20 sm:h-24 sm:w-24 rounded-full border-4 border-white object-cover shadow-lg shadow-[#F7C8B8]/70">
                            <div class="text-center sm:text-left">
                                <h2 class="text-xl sm:text-2xl font-semibold text-[#822021] font-['Cousine']">{{ $user->name }}</h2>
                                <p class="text-sm text-[#B49F9A] break-all font-['Open_Sans']">{{ $user->email }}</p>
                                @if ($user->phone)
                                    <p class="text-sm text-[#B49F9A] mt-1 font-['Open_Sans']">{{ $user->phone }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 sm:mt-8 grid gap-3 sm:gap-4 grid-cols-1 sm:grid-cols-2">
                        <div class="rounded-2xl bg-[#FFF5EF] p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Tanggal Lahir</p>
                            <p class="mt-2 text-sm font-semibold text-[#822021] break-words font-['Open_Sans']">{{ optional($user->birth_date)->translatedFormat('d F Y') ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Provinsi</p>
                            <p class="mt-2 text-sm font-semibold text-[#822021] break-words font-['Open_Sans']">{{ $user->province ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Kabupaten/Kota</p>
                            <p class="mt-2 text-sm font-semibold text-[#822021] break-words font-['Open_Sans']">{{ $user->city ?? 'Belum diisi' }}</p>
                        </div>
                        <div class="rounded-2xl bg-[#FFF5EF] p-3 sm:p-4">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Alamat</p>
                            <p class="mt-2 text-sm font-semibold text-[#822021] break-words font-['Open_Sans']">{{ $user->address ?? 'Belum diisi' }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-3xl bg-white/90 p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60">
                    <h2 class="text-xl sm:text-2xl font-semibold text-[#822021] font-['Cousine']">Tiket Event</h2>
                    <p class="mt-2 text-sm text-[#B49F9A] font-['Open_Sans']">Detail event yang akan kamu ikuti selanjutnya.</p>

                    @if ($upcomingRegistration)
                        <div class="mt-6 rounded-2xl bg-[#FFF1EC] p-5 shadow-inner">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#B49F9A]">Event Berikutnya</p>
                            <h3 class="mt-3 text-lg font-semibold text-[#822021] font-['Cousine']">{{ $upcomingRegistration->event->title }}</h3>
                            <dl class="mt-4 space-y-2 text-sm text-[#B49F9A] font-['Open_Sans']">
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-medium">Tanggal</dt>
                                    <dd class="sm:text-right">{{ optional($upcomingRegistration->event->start_at)->translatedFormat('d F Y, H:i') }}</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-medium">Lokasi</dt>
                                    <dd class="sm:text-right break-words">{{ $upcomingRegistration->event->location }}</dd>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:justify-between gap-1">
                                    <dt class="font-medium">Status Pembayaran</dt>
                                    <dd class="font-semibold text-[#822021] sm:text-right">{{ $upcomingRegistration->payment_status->label() }}</dd>
                                </div>
                            </dl>
                            <a href="{{ route('registrations.show', $upcomingRegistration) }}"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#FFBE8E] hover:text-[#822021]">
                                Lihat Detail
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    @else
                        <div class="mt-6 rounded-2xl border border-dashed border-[#FFBE8E] p-6 text-sm text-[#B49F9A]">
                            Belum ada event terjadwal. Yuk jelajahi <a href="{{ route('events.index') }}" class="font-semibold text-[#822021]">daftar event</a> dan amankan tempatmu!
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-3xl bg-white/90 p-4 sm:p-6 lg:p-8 shadow-xl shadow-[#F4B59E]/40 ring-1 ring-[#F7C8B8]/60">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-semibold text-[#822021] font-['Cousine']">Riwayat Aktivitas</h2>
                        <p class="text-sm text-[#B49F9A] font-['Open_Sans']">Pantau perkembangan pendaftaran, status pembayaran, dan refund terbaru.</p>
                    </div>
                    <div class="inline-flex rounded-full bg-[#FCF5E6] p-1 text-sm font-semibold text-[#822021] shadow-inner w-full sm:w-auto">
                        <a href="{{ route('profile.show') }}"
                            @class([
                                'rounded-full px-3 sm:px-4 py-2 transition flex-1 sm:flex-none text-center',
                                'bg-white text-[#822021] shadow-sm' => ! $isRefundView,
                                'text-[#B49F9A]' => $isRefundView,
                            ])>
                            Pendaftaran
                        </a>
                        <a href="{{ route('profile.show', ['tab' => 'refund']) }}"
                            @class([
                                'rounded-full px-3 sm:px-4 py-2 transition flex-1 sm:flex-none text-center',
                                'bg-white text-[#822021] shadow-sm' => $isRefundView,
                                'text-[#B49F9A]' => ! $isRefundView,
                            ])>
                            Refund
                        </a>
                    </div>
                </div>

                @if (! $isRefundView)
                    <div class="mt-6 overflow-x-auto rounded-2xl border border-[#F7C8B8]/80">
                        <table class="min-w-full divide-y divide-[#F7C8B8] text-sm">
                            <thead class="bg-[#FCF5E6] text-[#822021]">
                                <tr>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Event</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden sm:table-cell">Tanggal</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Total</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Status</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F7C8B8]/60 bg-white">
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
                                    <tr class="text-[#822021]">
                                        <td class="px-3 sm:px-6 py-4 align-top">
                                            <div class="font-semibold text-sm break-words">{{ $registration->event->title }}</div>
                                            <div class="text-[11px] text-[#B49F9A]">ID: reg{{ $registration->id }}</div>
                                            <div class="text-xs text-[#B49F9A] sm:hidden mt-1">
                                                {{ optional($registration->registered_at)->translatedFormat('d M Y') }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#B49F9A] hidden sm:table-cell">
                                            {{ optional($registration->registered_at)->translatedFormat('d F Y') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top font-semibold text-[#822021] text-sm">
                                            Rp{{ number_format($registration->transaction?->amount ?? $registration->event->price, 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <span class="inline-flex items-center rounded-full px-2 sm:px-3 py-1 text-xs font-semibold {{ $paymentBadge }}">
                                                {{ $registration->payment_status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <a href="{{ route('registrations.show', $registration) }}"
                                                class="inline-flex items-center gap-1 sm:gap-2 rounded-full bg-[#FFBE8E] px-3 sm:px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#FFBE8E]/30 transition hover:bg-[#822021] whitespace-nowrap">
                                                <span class="hidden sm:inline">Lihat Tiket</span>
                                                <span class="sm:hidden">Tiket</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-3 sm:px-6 py-8 text-center text-sm text-[#B49F9A]">
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
                    <div class="mt-6 overflow-x-auto rounded-2xl border border-[#F7C8B8]/80">
                        <table class="min-w-full divide-y divide-[#F7C8B8] text-sm">
                            <thead class="bg-[#FCF5E6] text-[#822021]">
                                <tr>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Event</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden lg:table-cell">No. Rekening</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Jumlah</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap hidden sm:table-cell">Tanggal</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Status</th>
                                    <th scope="col" class="px-3 sm:px-6 py-3 text-center font-semibold whitespace-nowrap">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F7C8B8]/60 bg-white">
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
                                    <tr class="text-[#822021]">
                                        <td class="px-3 sm:px-6 py-4 align-top">
                                            <div class="font-semibold text-sm break-words">{{ $registration->event->title }}</div>
                                            <div class="text-[11px] text-[#B49F9A]">ID: ref{{ $refund->id }}</div>
                                            <div class="text-xs text-[#B49F9A] sm:hidden lg:hidden mt-1">
                                                {{ data_get($registration->form_data, 'account_number', '-') }}
                                            </div>
                                            <div class="text-xs text-[#B49F9A] sm:hidden mt-1">
                                                {{ optional($refund->requested_at)->translatedFormat('d M Y') ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#B49F9A] hidden lg:table-cell">
                                            {{ data_get($registration->form_data, 'account_number', '-') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top font-semibold text-[#822021] text-sm">
                                            Rp{{ number_format($refund->transaction->amount ?? 0, 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-sm text-[#B49F9A] hidden sm:table-cell">
                                            {{ optional($refund->requested_at)->translatedFormat('d F Y') ?? '-' }}
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <span class="inline-flex items-center rounded-full px-2 sm:px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                                {{ $refund->status->label() }}
                                            </span>
                                        </td>
                                        <td class="px-3 sm:px-6 py-4 align-top text-center">
                                            <a href="{{ route('registrations.show', $registration) }}"
                                                class="inline-flex items-center gap-1 sm:gap-2 rounded-full bg-[#FFBE8E] px-3 sm:px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#FFBE8E]/30 transition hover:bg-[#822021] whitespace-nowrap">
                                                <span class="hidden sm:inline">Lihat Tiket</span>
                                                <span class="sm:hidden">Tiket</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-3 sm:px-6 py-8 text-center text-sm text-[#B49F9A]">
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