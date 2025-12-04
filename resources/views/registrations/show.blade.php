@php
    use App\Enums\PaymentStatus;
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;

    $transaction = $registration->transaction;
    $paymentStatus = $transaction?->status;
    $hasProof = filled($transaction?->payment_proof_path);

    $isAwaitingVerification = $paymentStatus === PaymentStatus::AwaitingVerification;
    $isVerified = $paymentStatus === PaymentStatus::Verified;
    $isRejected = $paymentStatus === PaymentStatus::Rejected;
    $isRefunded = $paymentStatus === PaymentStatus::Refunded;

    $currentStep = ($isAwaitingVerification || $isVerified || $isRefunded) ? 3 : 2;
    if ($hasProof && ! $isAwaitingVerification && ! $isVerified && ! $isRefunded && ! $isRejected) {
        $currentStep = 3;
    }

    $steps = [
        ['label' => 'Data Peserta'],
        ['label' => 'Informasi Pembayaran'],
        ['label' => 'Konfirmasi'],
    ];

    $refund = $transaction?->refund;
    $showTicket = $isVerified || $isRefunded || $refund;
    $showCountdown = ! $showTicket && ! $hasProof;
@endphp

<x-layouts.app :title="'Pembayaran Pendaftaran'">
    <section class="bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Profil
            </a>

            @if ($showTicket)
                <div id="tiket" class="space-y-6">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Detail Tiket Event</p>
                        <h1 class="mt-2 text-3xl font-semibold text-[#2C1E1E]">{{ $registration->event->title }}</h1>
                        <p class="mt-2 max-w-2xl text-sm text-[#9A5A46]">Lihat tiket, status pembayaran, dan ajukan refund jika berhalangan hadir.</p>
                    </div>

                    <div class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
                        <div class="space-y-6">
                            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-xl shadow-[#FAD6C7]/40 backdrop-blur">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Informasi Event</p>
                                        <h2 class="mt-2 text-2xl font-semibold text-[#7C3A2D]">{{ $registration->event->title }}</h2>
                                        <p class="mt-1 text-sm text-[#9A5A46]">
                                            {{ Str::limit(strip_tags($registration->event->description ?? ''), 120) ?: 'Detail event akan diinformasikan.' }}
                                        </p>
                                    </div>
                                    <div class="h-20 w-28 rounded-2xl bg-gradient-to-br from-[#FFE1D0] to-[#FFD2C0] shadow-inner"></div>
                                </div>

                                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-2xl bg-[#FFF5EF] px-4 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Tanggal</p>
                                        <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ optional($registration->event->start_at)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-[#FFF5EF] px-4 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Waktu</p>
                                        <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">
                                            {{ optional($registration->event->start_at)->translatedFormat('H:i') }} - {{ optional($registration->event->end_at)->translatedFormat('H:i') }} WIB
                                        </p>
                                    </div>
                                    <div class="rounded-2xl bg-[#FFF5EF] px-4 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Tempat</p>
                                        <p class="mt-2 text-sm font-semibold text-[#7C3A2D]">{{ $registration->event->venue_name }}</p>
                                        <p class="text-xs text-[#9A5A46]">{{ $registration->event->venue_address }}</p>
                                    </div>
                                    <div class="rounded-2xl bg-[#FFF5EF] px-4 py-3">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Harga</p>
                                        <p class="mt-2 text-xl font-semibold text-[#7C3A2D]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</p>
                                        <p class="text-[11px] text-[#C99F92]">ID: reg{{ $registration->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/95 p-6 shadow-xl shadow-[#FAD6C7]/40 backdrop-blur">
                                <h3 class="text-lg font-semibold text-[#2C1E1E]">Detail Pendaftaran</h3>
                                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                    <div class="rounded-2xl border border-dashed border-[#FAD6C7] bg-[#FFF5EF] px-4 py-4 text-sm text-[#6F4F4F]">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Bukti Pembayaran</p>
                                        @if ($transaction?->payment_proof_path)
                                            <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#FF8A64] px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B]">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <p class="mt-2 text-sm font-semibold text-[#C65B74]">Belum ada bukti pembayaran.</p>
                                        @endif
                                    </div>
                                    <div class="rounded-2xl border border-dashed border-[#FAD6C7] bg-[#F7FFF9] px-4 py-4 text-sm text-[#6F4F4F]">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#2F9A55]">Status</p>
                                        <span @class([
                                            'mt-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                            'bg-[#E4F5E9] text-[#2F9A55]' => $isVerified,
                                            'bg-[#FDE1E7] text-[#BA1B1D]' => $isRejected,
                                            'bg-[#FDF7D8] text-[#B89530]' => $isAwaitingVerification,
                                            'bg-[#E8F3FF] text-[#2B6CB0]' => $isRefunded,
                                        ])>
                                            {{ $paymentStatus?->label() ?? 'Tidak ada data' }}
                                        </span>
                                        @if ($transaction?->verified_at)
                                            <p class="mt-1 text-xs text-[#9A5A46]">Terverifikasi: {{ $transaction->verified_at->translatedFormat('d F Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 rounded-2xl border border-dashed border-[#FAD6C7]/80 bg-white/80 px-4 py-4 text-sm text-[#6F4F4F]">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Catatan</p>
                                    <p class="mt-2 text-sm text-[#7C3A2D]">Pembayaran sudah dikonfirmasi. Simpan tiket ini dan hadir tepat waktu.</p>
                                </div>
                            </div>
                        </div>

                        <aside class="space-y-6">
                            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/90 p-6 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                                <h3 class="text-lg font-semibold text-[#2C1E1E]">Informasi Mentor</h3>
                                <div class="mt-3 rounded-2xl bg-[#FFF5EF] px-4 py-3 text-sm text-[#6F4F4F]">
                                    <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Nama</p>
                                    <p class="mt-1 text-base font-semibold text-[#7C3A2D]">{{ $registration->event->tutor_name ?? 'Pengajar akan diumumkan' }}</p>
                                    <p class="mt-1 text-xs text-[#9A5A46]">Pembimbing utama workshop.</p>
                                </div>
                            </div>

                            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/90 p-6 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                                <div class="flex items-center justify-between gap-3">
                                    <div>
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Pengajuan Refund</p>
                                        <p class="text-sm text-[#6F4F4F]">Ajukan refund maksimal 3 hari sebelum event.</p>
                                    </div>
                                    @if ($refund)
                                        <span @class([
                                            'inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold',
                                            'bg-[#FDF7D8] text-[#B89530]' => $refund->status?->value === 'pending',
                                            'bg-[#E4F5E9] text-[#2F9A55]' => in_array($refund->status?->value, ['approved', 'completed']),
                                            'bg-[#FDE1E7] text-[#BA1B1D]' => $refund->status?->value === 'rejected',
                                        ])>
                                            {{ $refund->status->label() }}
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 space-y-3 text-sm text-[#6F4F4F]">
                                    <p class="font-semibold text-[#7C3A2D]">Syarat & Ketentuan:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs text-[#9A5A46]">
                                        <li>Refund maksimal 3 hari sebelum event.</li>
                                        <li>Biaya admin 10% dari total.</li>
                                        <li>Proses 3-7 hari kerja setelah disetujui.</li>
                                    </ul>
                                </div>

                                @if ($refund)
                                    <div class="mt-4 rounded-2xl border border-dashed border-[#FAD6C7] bg-white/80 px-4 py-3 text-sm text-[#6F4F4F]">
                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Detail Refund</p>
                                        <p class="mt-2 text-sm text-[#7C3A2D]">Alasan: {{ $refund->reason }}</p>
                                        <p class="text-xs text-[#9A5A46]">Diajukan: {{ optional($refund->requested_at)->translatedFormat('d F Y H:i') ?? '-' }}</p>
                                    </div>
                                @else
                                    @can('requestRefund', $registration)
                                        <a href="{{ route('registrations.refund.create', $registration) }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-[#822021] px-5 py-3 text-sm font-semibold text-[#FAF8F1] shadow-md shadow-[#B49F9A]/30 transition hover:-translate-y-0.5 hover:bg-[#822021]/70">
                                            Ajukan Refund
                                        </a>
                                    @else
                                        <p class="mt-4 text-sm font-semibold text-[#C65B74]">Refund tersedia setelah pembayaran terverifikasi.</p>
                                    @endcan
                                @endif
                            </div>
                        </aside>
                    </div>
                </div>
            @else
                <div id="tiket" class="grid gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
                    <div class="rounded-[32px] border border-[#FAD6C7] bg-white/95 p-8 shadow-xl shadow-[#FAD6C7]/40 backdrop-blur">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Step Pendaftaran</p>
                                <h1 class="mt-2 text-2xl font-semibold text-[#2C1E1E]">
                                    {{ $currentStep === 3 ? 'Konfirmasi Pembayaran' : 'Informasi Pembayaran' }}
                                </h1>
                            </div>
                            <div class="flex items-center gap-2 text-sm font-semibold text-[#C65B74]">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#FF8A64] text-white">{{ $currentStep }}</span>
                                <span>Langkah {{ $currentStep }} dari 3</span>
                            </div>
                        </div>

                        <div class="mt-6 grid gap-3 md:grid-cols-3">
                            @foreach ($steps as $index => $step)
                                @php($stepNumber = $index + 1)
                                <div @class([
                                    'rounded-2xl px-4 py-3 text-sm font-semibold transition',
                                    'border border-[#FAD6C7] bg-[#FFF5EF] text-[#C65B74]' => $stepNumber <= $currentStep,
                                    'border border-dashed border-[#FAD6C7]/70 text-[#C65B74]/60' => $stepNumber > $currentStep,
                                ])>
                                    {{ $step['label'] }}
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 space-y-8">
                            @if ($isAwaitingVerification)
                                <x-status-card-success message="Bukti pembayaran berhasil dikirim." sub="Tim admin sedang melakukan verifikasi." />
                            @elseif ($isVerified)
                                <x-status-card-success message="Pendaftaran berhasil." sub="Pembayaran Anda telah terverifikasi." />
                            @elseif ($isRefunded)
                                <x-status-card-warning message="Dana telah dikembalikan." sub="Silakan cek rekening Anda." />
                            @elseif ($isRejected)
                                <x-status-card-error message="Bukti pembayaran ditolak." sub="Silakan unggah ulang bukti yang sesuai." />
                            @endif

                            @if (! $isAwaitingVerification && ! $isVerified && ! $isRefunded)
                                <div class="grid gap-6 md:grid-cols-2">
                                    <div class="space-y-5">
                                        <div class="rounded-[28px] border border-[#FAD6C7] bg-[#FFF5EF] px-6 py-5 shadow-inner">
                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Informasi Pembayaran</p>
                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Metode Pembayaran</p>
                                            <p class="mt-1 text-sm font-semibold text-[#7C3A2D]">{{ $paymentMethod }}</p>

                                            @if ($paymentAccount)
                                                <h2 class="mt-2 text-xl font-semibold text-[#2C1E1E]">Virtual Account {{ $paymentAccount['bank'] }}</h2>
                                                <dl class="mt-4 space-y-3 text-sm text-[#5F4C4C]">
                                                    <div>
                                                        <dt class="text-[#A04E62]">Nomor Rekening</dt>
                                                        <dd class="text-lg font-semibold tracking-[0.2em] text-[#2C1E1E]">{{ $paymentAccount['number'] }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-[#A04E62]">Atas Nama</dt>
                                                        <dd class="font-medium">{{ $paymentAccount['name'] }}</dd>
                                                    </div>
                                                    @if (! empty($paymentAccount['branch']))
                                                        <div>
                                                            <dt class="text-[#A04E62]">Cabang</dt>
                                                            <dd>{{ $paymentAccount['branch'] }}</dd>
                                                        </div>
                                                    @endif
                                                </dl>
                                                @if (! empty($paymentAccount['notes']))
                                                    <p class="mt-4 rounded-2xl border border-dashed border-[#FAD6C7] bg-white/80 px-4 py-3 text-xs text-[#A04E62]">
                                                        {{ $paymentAccount['notes'] }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="rounded-[28px] border border-dashed border-[#FAD6C7]/80 bg-white/70 px-6 py-5 text-sm text-[#6F4F4F] shadow-sm">
                                            <h3 class="text-base font-semibold text-[#2C1E1E]">Petunjuk Pembayaran</h3>
                                            <ul class="mt-3 space-y-2 list-disc list-inside">
                                                <li>Transfer sebesar <span class="font-semibold text-[#C65B74]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</span></li>
                                                <li>Gunakan berita transfer “Workshop {{ $registration->event->title }}”</li>
                                                <li>Unggah bukti pembayaran melalui form di samping</li>
                                            </ul>
                                        </div>

                                        @if ($showCountdown)
                                            <div
                                                data-payment-timer
                                                data-seconds="10"
                                                data-expire-url="{{ route('registrations.expire', $registration) }}"
                                                data-event-url="{{ route('events.show', $registration->event) }}"
                                                class="relative overflow-hidden rounded-[28px] border border-[#FAD6C7] bg-gradient-to-br from-[#FFF3EA] via-white to-[#FFE1D0] p-5 shadow-xl shadow-[#FAD6C7]/50"
                                            >
                                                <div class="absolute inset-0 opacity-40 blur-3xl" style="background: radial-gradient(circle at 20% 20%, #FFB8A2 0%, transparent 35%), radial-gradient(circle at 80% 0%, #C65B74 0%, transparent 30%);"></div>
                                                <div class="relative flex flex-col gap-4 text-[#2C1E1E]">
                                                    <div class="flex items-center justify-between gap-3">
                                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Konfirmasi Pembayaran</p>
                                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#2F9A55]/10 px-3 py-1 text-[12px] font-semibold text-[#2F9A55]">
                                                            Auto reload in <span data-countdown-label class="tabular-nums">00:05</span>
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-4 rounded-2xl bg-white/70 p-4 shadow-inner shadow-[#FAD6C7]/30 backdrop-blur">
                                                        <div class="relative flex h-16 w-16 items-center justify-center">
                                                            <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36">
                                                                <circle cx="18" cy="18" r="16" fill="none" stroke="#FAD6C7" stroke-width="4" class="opacity-60" />
                                                                <circle cx="18" cy="18" r="16" fill="none" stroke="url(#timerGradient)" stroke-width="4" stroke-linecap="round" stroke-dasharray="100" stroke-dashoffset="0" data-countdown-progress />
                                                                <defs>
                                                                    <linearGradient id="timerGradient" x1="0%" y1="0%" x2="100%" y2="0%">
                                                                        <stop offset="0%" stop-color="#FF8A64"/>
                                                                        <stop offset="100%" stop-color="#C65B74"/>
                                                                    </linearGradient>
                                                                </defs>
                                                            </svg>
                                                            <div class="absolute inset-0 flex items-center justify-center text-lg font-bold text-[#C65B74]" data-countdown-number>5</div>
                                                        </div>
                                                        <div class="space-y-2">
                                                            <h4 class="text-base font-semibold text-[#2C1E1E]">Segera unggah bukti pembayaran</h4>
                                                            <p class="text-sm text-[#6F4F4F]">Jika waktu habis, halaman otomatis dimuat ulang. Bila masih belum ada bukti pembayaran, Anda akan diarahkan kembali ke detail event.</p>
                                                        </div>
                                                    </div>
                                                    <div class="relative h-2 overflow-hidden rounded-full bg-[#FDE5D7]">
                                                        <div class="absolute inset-y-0 left-0 w-0 rounded-full bg-gradient-to-r from-[#FF8A64] to-[#C65B74]" data-countdown-bar></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <div>
                                        <div class="rounded-[28px] border border-[#FAD6C7] bg-white/90 px-6 py-6 shadow-inner">
                                            <form method="POST" action="{{ route('registrations.payment-proof', $registration) }}" enctype="multipart/form-data" class="space-y-6">
                                                @csrf
                                                <div>
                                                    <label for="payment_proof" class="block text-sm font-semibold text-[#2C1E1E]">Unggah Bukti Pembayaran</label>
                                                    <input type="file" id="payment_proof" name="payment_proof" class="sr-only" accept="image/*,.pdf" required data-proof-input>
                                                    <label for="payment_proof" class="mt-3 flex cursor-pointer flex-col items-center justify-center gap-4 rounded-[24px] border border-dashed border-[#FAD6C7] bg-[#FFF5EF] px-6 py-10 text-center text-sm font-semibold text-[#C65B74] shadow-inner transition hover:bg-[#FFE8DB]">
                                                        <div data-proof-empty>
                                                            <p class="text-base">Klik untuk upload</p>
                                                            <p class="text-xs font-normal text-[#B87A7A]">Format JPG, PNG, PDF • Maksimal 5MB</p>
                                                        </div>
                                                        <div class="hidden w-full text-[#7C3A2D]" data-proof-preview>
                                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">File dipilih</p>
                                                            <p class="mt-3 break-words text-sm font-semibold" data-proof-name>-</p>
                                                            <p class="text-xs font-medium text-[#B87A7A]" data-proof-size></p>
                                                        </div>
                                                    </label>
                                                    @error('payment_proof')
                                                        <p class="mt-3 text-xs font-medium text-[#BA1B1D]">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex flex-wrap items-center justify-between gap-3">
                                                    <a href="{{ route('events.show', $registration->event) }}" class="inline-flex items-center justify-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74] transition hover:bg-[#FFF0E6]">Batal</a>
                                                    <button type="submit" data-proof-submit disabled class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:bg-[#F9744B] disabled:bg-[#F5B19D] disabled:text-white/60 disabled:cursor-not-allowed">
                                                        Lanjutkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="konfirmasi" class="rounded-[28px] border border-[#FAD6C7] bg-white/90 px-6 py-6 shadow-inner text-sm text-[#6F4F4F]">
                                    <h3 class="text-base font-semibold text-[#2C1E1E]">Detail Pembayaran</h3>
                                    <dl class="mt-4 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#A04E62]">Status</dt>
                                            <dd class="font-semibold text-[#C65B74]">{{ $paymentStatus?->label() }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#A04E62]">Nominal</dt>
                                            <dd class="font-semibold text-[#2C1E1E]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#A04E62]">Metode</dt>
                                            <dd class="font-medium text-[#5F4C4C]">{{ $paymentMethod }}</dd>
                                        </div>
                                        @if ($transaction?->paid_at)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#A04E62]">Dibayar</dt>
                                                <dd>{{ $transaction->paid_at->translatedFormat('d F Y H:i') }}</dd>
                                            </div>
                                        @endif
                                        @if ($transaction?->payment_proof_path)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#A04E62]">Bukti</dt>
                                                <dd>
                                                    <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                                                        Lihat Bukti
                                                    </a>
                                                </dd>
                                            </div>
                                        @endif
                                    </dl>
                                    <div class="mt-6 flex flex-wrap items-center gap-3">
                                        <a href="{{ route('registrations.index') }}" class="inline-flex items-center justify-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74]">Lihat Riwayat</a>
                                        <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30">Kembali ke Events</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <aside class="space-y-6">
                        <div class="rounded-[32px] border border-[#FAD6C7] bg-white/85 p-6 shadow-lg shadow-[#FAD6C7]/40 backdrop-blur">
                            <h2 class="text-lg font-semibold text-[#2C1E1E]">Ringkasan Event</h2>
                            <div class="mt-4 space-y-4 text-sm text-[#5F4C4C]">
                                <div class="rounded-2xl bg-[#FFF0E6] px-4 py-3 text-[#C65B74]">
                                    {{ $registration->event->title }}
                                </div>
                                <dl class="space-y-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#A04E62]">Tanggal</dt>
                                        <dd class="text-right">{{ $registration->event->start_at->translatedFormat('d F Y') }}</dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#A04E62]">Waktu</dt>
                                        <dd class="text-right">
                                            {{ $registration->event->start_at->translatedFormat('H:i') }} -
                                            {{ $registration->event->end_at->translatedFormat('H:i') }} WIB
                                        </dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#A04E62]">Venue</dt>
                                        <dd class="text-right">
                                            <span class="font-semibold text-[#2C1E1E]">{{ $registration->event->venue_name }}</span>
                                            <span class="block text-xs text-[#5F4C4C]">{{ $registration->event->venue_address }}</span>
                                        </dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#A04E62]">Pemateri</dt>
                                        <dd class="text-right">{{ $registration->event->tutor_name }}</dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#A04E62]">Nominal</dt>
                                        <dd class="text-right font-semibold text-[#C65B74]">
                                            Rp{{ number_format($registration->event->price, 0, ',', '.') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <div class="rounded-[28px] border border-dashed border-[#FAD6C7]/80 bg-white/70 p-6 text-sm text-[#5F4C4C] shadow-sm">
                            <h3 class="text-base font-semibold text-[#2C1E1E]">Butuh Bantuan?</h3>
                            <p class="mt-2 text-sm text-[#6F4F4F]">
                                Hubungi admin Kreasi Hangat di
                                <span class="font-semibold text-[#C65B74]">support@kreasihangat.com</span>
                            </p>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>

    @if (! $showTicket)
        @push('scripts')
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const timerEl = document.querySelector('[data-payment-timer]');
            if (timerEl) {
                const totalSeconds = Number(timerEl.dataset.seconds ?? 5);
                const bar = timerEl.querySelector('[data-countdown-bar]');
                const number = timerEl.querySelector('[data-countdown-number]');
                const label = timerEl.querySelector('[data-countdown-label]');
                const progress = timerEl.querySelector('[data-countdown-progress]');
                const eventUrl = timerEl.dataset.eventUrl;
                const expireUrl = timerEl.dataset.expireUrl;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                let remaining = totalSeconds;

                const formatTime = (value) => value.toString().padStart(2, '0');
                const cleanupAndRedirect = () => {
                    window.location.href = eventUrl || '/events';
                };
                const expireRegistration = async () => {
                    if (!expireUrl || !csrf) {
                        cleanupAndRedirect();
                        return;
                    }

                    try {
                        const response = await fetch(expireUrl, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                            },
                        });

                        if (!response.ok) {
                            cleanupAndRedirect();
                            return;
                        }

                        const data = await response.json();
                        window.location.href = data.redirect || eventUrl || '/events';
                    } catch (error) {
                        cleanupAndRedirect();
                    }
                };

                const render = () => {
                    const percent = Math.max(0, Math.min(100, (remaining / totalSeconds) * 100));
                    if (bar) bar.style.width = `${100 - percent}%`;
                    if (number) number.textContent = remaining;
                    if (label) label.textContent = `00:${formatTime(remaining)}`;
                    if (progress) progress.style.strokeDashoffset = (100 - percent).toString();
                };

                const tick = () => {
                    remaining -= 1;
                    if (remaining < 0) {
                        expireRegistration();
                        return;
                    }
                    render();
                    setTimeout(tick, 1000);
                };

                render();
                setTimeout(tick, 1000);
            }

            const input = document.querySelector('[data-proof-input]');
            const submit = document.querySelector('[data-proof-submit]');
            const emptyState = document.querySelector('[data-proof-empty]');
            const previewState = document.querySelector('[data-proof-preview]');
            const fileNameEl = document.querySelector('[data-proof-name]');
            const fileSizeEl = document.querySelector('[data-proof-size]');

            if (!input || !submit) {
                return;
            }

            const formatBytes = (bytes) => {
                if (!Number.isFinite(bytes) || bytes <= 0) {
                    return '';
                }
                const units = ['B', 'KB', 'MB', 'GB'];
                const exponent = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
                return `${(bytes / 1024 ** exponent).toFixed(exponent === 0 ? 0 : 1)} ${units[exponent]}`;
            };

            const toggle = () => {
                const file = input.files[0] ?? null;
                submit.disabled = !file;

                if (!emptyState || !previewState || !fileNameEl || !fileSizeEl) {
                    return;
                }

                if (!file) {
                    emptyState.classList.remove('hidden');
                    previewState.classList.add('hidden');
                    fileNameEl.textContent = '-';
                    fileSizeEl.textContent = '';
                    return;
                }

                emptyState.classList.add('hidden');
                previewState.classList.remove('hidden');
                fileNameEl.textContent = file.name;
                fileSizeEl.textContent = formatBytes(file.size);
            };

            input.addEventListener('change', toggle);
            toggle();
        });
        </script>
        @endpush
    @endif
</x-layouts.app>
