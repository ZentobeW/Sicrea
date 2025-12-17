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
    $showCountdown = ! $showTicket && ($isRejected || ! $hasProof);

    $paymentTimeoutMinutes ??= config('payment.proof_timeout_minutes', 5);
    $remainingSeconds = isset($remainingSeconds) ? max(0, (int) $remainingSeconds) : 0;
    $initialCountdownLabel = $remainingSeconds > 0 ? gmdate('i:s', $remainingSeconds) : '00:00';
@endphp

<x-layouts.app :title="'Pembayaran Pendaftaran'">
    
    {{-- Custom Styles --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, label, input, button, dl, dt, dd {
            font-family: 'Poppins', sans-serif !important;
        }

        /* Button Hover Effect */
        .btn-action {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-action:hover:not(:disabled) {
            transform: scale(1.05);
            background-color: #822021 !important;
            color: #FCF5E6 !important;
            box-shadow: 0 10px 15px -3px rgba(130, 32, 33, 0.3);
        }
    </style>

    {{-- Main Background: FFDEF8 --}}
    <section class="bg-[#FCF5E6] py-8 md:py-12 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 md:space-y-6">
            
            {{-- Tombol Kembali --}}
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:opacity-75 transition-opacity">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Profil
            </a>

            @if ($showTicket)
                {{-- TAMPILAN TIKET (Step Selesai) --}}
                <div id="tiket" class="space-y-4 md:space-y-6">
                    <div class="text-center md:text-left">
                        <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Detail Tiket Event</p>
                        <p class="mt-2 max-w-2xl text-sm md:text-base text-[#822021]/80">Lihat tiket, status pembayaran, dan ajukan refund jika berhalangan hadir.</p>
                    </div>

                    <div class="grid gap-4 md:gap-6 lg:grid-cols-2 lg:items-start">
                        <div class="space-y-4 md:space-y-6">
                            {{-- Box Informasi Event: BG FAF8F1, Border 822021 --}}
                            <div class="rounded-2xl md:rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-xl shadow-[#822021]/10">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Informasi Event</p>
                                        <h2 class="mt-2 text-xl md:text-2xl font-bold text-[#822021]">{{ $registration->event->title }}</h2>
                                        <p class="mt-1 text-sm md:text-base text-[#822021]/80 leading-relaxed">
                                            {{ Str::limit(strip_tags($registration->event->description ?? ''), 120) ?: 'Detail event akan diinformasikan.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 grid gap-3 grid-cols-1 sm:grid-cols-2">
                                    {{-- Info Cards --}}
                                    <div class="rounded-xl md:rounded-2xl bg-[#FFDEF8] px-3 py-2.5 border border-[#822021]/20">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Tanggal</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021]">{{ optional($registration->event->start_at)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FFDEF8] px-3 py-2.5 border border-[#822021]/20">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Waktu</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021]">
                                            {{ optional($registration->event->start_at)->translatedFormat('H:i') }} - {{ optional($registration->event->end_at)->translatedFormat('H:i') }} WIB
                                        </p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FFDEF8] px-3 py-2.5 border border-[#822021]/20">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Tempat</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021]">{{ $registration->event->venue_name }}</p>
                                        <p class="text-xs text-[#822021]/70 mt-0.5">{{ $registration->event->venue_address }}</p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FFDEF8] px-3 py-2.5 border border-[#822021]/20">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Harga</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-[#822021]/70 mt-0.5">ID: reg{{ $registration->id }}</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Box Mentor --}}
                            <div class="rounded-2xl md:rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-xl shadow-[#822021]/10">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Informasi Mentor</p>
                                <div class="mt-3 rounded-xl md:rounded-2xl bg-[#FFDEF8] px-3 md:px-4 py-3 text-sm border border-[#822021]/20">
                                    <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Nama</p>
                                    <p class="mt-1 text-base md:text-lg font-bold text-[#822021]">{{ $registration->event->tutor_name ?? 'Pengajar akan diumumkan' }}</p>
                                    <p class="mt-1 text-xs md:text-sm text-[#822021]/70">Pembimbing utama workshop.</p>
                                </div>
                            </div>
                        </div>

                        <aside class="flex flex-col space-y-4 md:space-y-6">
                            {{-- Box Detail Pendaftaran --}}
                            <div class="rounded-2xl md:rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-lg shadow-[#822021]/10 flex-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Detail Pendaftaran</p>
                                <div class="mt-4 grid gap-3 md:gap-4 sm:grid-cols-2">
                                    <div class="rounded-xl md:rounded-2xl border border-[#822021]/20 bg-[#FFDEF8] px-3 md:px-4 py-4 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Bukti Pembayaran</p>
                                        @if ($transaction?->payment_proof_path)
                                            <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="btn-action mt-3 inline-flex items-center gap-2 rounded-full bg-[#822021] px-3 md:px-4 py-2 text-xs font-semibold text-[#FCF5E6] shadow-md">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <p class="mt-2 text-sm font-semibold text-[#822021]">Belum ada bukti pembayaran.</p>
                                        @endif
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl border border-[#822021]/20 bg-[#FFDEF8] px-3 md:px-4 py-4 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Status</p>
                                        <span @class([
                                            'mt-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold',
                                            'bg-[#E4F5E9] text-[#2F9A55]' => $isVerified,
                                            'bg-[#FDE1E7] text-[#BA1B1D]' => $isRejected,
                                            'bg-[#FDF7D8] text-[#B89530]' => $isAwaitingVerification,
                                            'bg-rose-500 text-rose-900' => $isRefunded,
                                        ])>
                                            {{ $paymentStatus?->label() ?? 'Tidak ada data' }}
                                        </span>
                                        @if ($transaction?->verified_at)
                                            <p class="mt-1 text-xs text-[#822021]/60">Terverifikasi: {{ $transaction->verified_at->translatedFormat('d F Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 rounded-xl md:rounded-2xl border border-[#822021]/20 bg-[#FFDEF8]/50 px-3 md:px-4 py-4 text-sm">
                                    <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Catatan</p>
                                    <p class="mt-2 text-sm md:text-base text-[#822021]">Pembayaran sudah dikonfirmasi. Simpan tiket ini dan hadir tepat waktu.</p>
                                </div>
                            </div>

                            {{-- Box Refund --}}
                            <div class="rounded-2xl md:rounded-[28px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-lg shadow-[#822021]/10">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Pengajuan Refund</p>
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
                                    @else
                                        @can('requestRefund', $registration)
                                            <a href="{{ route('registrations.refund.create', $registration) }}" class="btn-action inline-flex items-center gap-2 rounded-full bg-[#822021] px-3 md:px-4 py-2 text-xs font-semibold text-[#FCF5E6] shadow-md">
                                                Ajukan Refund
                                            </a>
                                        @endcan
                                    @endif
                                </div>

                                <div class="mt-4 space-y-3 text-sm">
                                    <p class="font-bold text-[#822021]">Syarat & Ketentuan:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs md:text-sm text-[#822021]/80">
                                        <li>Refund maksimal 3 hari sebelum event.</li>
                                        <li>Biaya admin 10% dari total.</li>
                                        <li>Proses 3-7 hari kerja setelah disetujui.</li>
                                    </ul>
                                </div>

                                @if ($refund)
                                    <div class="mt-4 rounded-xl md:rounded-2xl border border-dashed border-[#822021]/40 bg-[#FFDEF8]/50 px-3 md:px-4 py-3 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Detail Refund</p>
                                        <p class="mt-2 text-sm md:text-base text-[#822021]">Alasan: {{ $refund->reason }}</p>
                                        <p class="text-xs md:text-sm text-[#822021]/70">Diajukan: {{ optional($refund->requested_at)->translatedFormat('d F Y H:i') ?? '-' }}</p>
                                    </div>
                                @else
                                    @cannot('requestRefund', $registration)
                                        <p class="mt-4 text-sm font-semibold text-[#822021]">Refund tersedia setelah pembayaran terverifikasi.</p>
                                    @endcannot
                                @endif
                            </div>
                        </aside>
                    </div>
                </div>
            @else
                {{-- TAMPILAN UPLOAD BUKTI / PEMBAYARAN --}}
                <div id="tiket" class="grid gap-4 md:gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
                    <div class="rounded-2xl md:rounded-[32px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 lg:p-8 shadow-xl shadow-[#822021]/10">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="text-center md:text-left">
                                <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Step Pendaftaran</p>
                                <h1 class="mt-2 text-xl md:text-2xl lg:text-3xl font-bold text-[#822021]">
                                    {{ $currentStep === 3 ? 'Konfirmasi Pembayaran' : 'Informasi Pembayaran' }}
                                </h1>
                            </div>
                            <div class="flex items-center justify-center md:justify-start gap-2 text-sm font-semibold text-[#822021]">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#822021] text-[#FCF5E6] font-bold">{{ $currentStep }}</span>
                                <span>Langkah {{ $currentStep }} dari 3</span>
                            </div>
                        </div>

                        {{-- Progress Steps --}}
                        <div class="mt-4 md:mt-6 grid gap-2 md:gap-3 grid-cols-1 sm:grid-cols-3">
                            @foreach ($steps as $index => $step)
                                @php($stepNumber = $index + 1)
                                <div @class([
                                    'rounded-xl md:rounded-2xl px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold transition text-center',
                                    'border border-[#822021] bg-[#FFDEF8] text-[#822021]' => $stepNumber <= $currentStep,
                                    'border border-dashed border-[#822021]/40 text-[#822021]/60' => $stepNumber > $currentStep,
                                ])>
                                    {{ $step['label'] }}
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 md:mt-8 space-y-6 md:space-y-8">
                            {{-- Status Messages --}}
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
                                <div class="grid gap-4 md:gap-6 lg:grid-cols-2">
                                    <div class="space-y-4 md:space-y-5">
                                        {{-- Info Rekening --}}
                                        <div class="rounded-2xl md:rounded-[28px] border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 md:px-6 py-4 md:py-5">
                                            <p class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Informasi Pembayaran</p>
                                            <p class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60 mt-2">Metode Pembayaran</p>
                                            <p class="mt-1 text-sm md:text-base font-bold text-[#822021]">{{ $paymentMethod }}</p>

                                            @if ($paymentAccount)
                                                <h2 class="mt-2 text-lg md:text-xl font-bold text-[#822021]">Virtual Account {{ $paymentAccount['bank'] }}</h2>
                                                <dl class="mt-4 space-y-3 text-sm md:text-base">
                                                    <div>
                                                        <dt class="text-[#822021]/70">Nomor Rekening</dt>
                                                        <dd class="text-base md:text-lg font-bold tracking-[0.2em] text-[#822021]">{{ $paymentAccount['number'] }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-[#822021]/70">Atas Nama</dt>
                                                        <dd class="font-semibold text-[#822021]">{{ $paymentAccount['name'] }}</dd>
                                                    </div>
                                                    @if (! empty($paymentAccount['branch']))
                                                        <div>
                                                            <dt class="text-[#822021]/70">Cabang</dt>
                                                            <dd class="text-[#822021]">{{ $paymentAccount['branch'] }}</dd>
                                                        </div>
                                                    @endif
                                                </dl>
                                                @if (! empty($paymentAccount['notes']))
                                                    <p class="mt-4 rounded-xl md:rounded-2xl border border-dashed border-[#822021]/40 bg-white/80 px-3 md:px-4 py-3 text-xs md:text-sm text-[#822021]/70">
                                                        {{ $paymentAccount['notes'] }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>

                                        {{-- Petunjuk Pembayaran --}}
                                        <div class="rounded-2xl md:rounded-[28px] border border-dashed border-[#822021]/40 bg-[#FFDEF8]/30 px-4 md:px-6 py-4 md:py-5 text-sm">
                                            <h3 class="text-base md:text-lg font-bold text-[#822021]">Petunjuk Pembayaran</h3>
                                            <ul class="mt-3 space-y-2 list-disc list-inside text-[#822021]/70">
                                                <li>Transfer sebesar <span class="font-bold text-[#822021]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</span></li>
                                                <li>Gunakan berita transfer "Workshop {{ $registration->event->title }}"</li>
                                                <li>Unggah bukti pembayaran melalui form di samping</li>
                                            </ul>
                                        </div>

                                        @if ($showCountdown)
                                            {{-- Countdown Timer --}}
                                            <div data-payment-timer data-seconds="{{ $remainingSeconds }}" data-expire-url="{{ route('registrations.expire', $registration) }}" data-event-url="{{ route('events.show', $registration->event) }}" class="relative overflow-hidden rounded-[28px] border border-[#822021]/40 bg-gradient-to-br from-[#FFDEF8] to-white p-5 shadow-lg">
                                                <div class="relative flex flex-col gap-4 text-[#822021]">
                                                    <div class="flex items-center justify-between gap-3">
                                                        <p class="text-[11px] font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Konfirmasi Pembayaran</p>
                                                        <span class="inline-flex items-center gap-2 rounded-full bg-[#822021]/10 px-3 py-1 text-[12px] font-semibold text-[#822021]">
                                                            Auto reload in <span data-countdown-label class="tabular-nums">{{ $initialCountdownLabel }}</span>
                                                        </span>
                                                    </div>
                                                    <div class="flex items-center gap-4 rounded-2xl bg-white/70 p-4 shadow-inner">
                                                        <div class="relative flex h-16 w-16 items-center justify-center">
                                                            <svg class="h-16 w-16 -rotate-90" viewBox="0 0 36 36">
                                                                <circle cx="18" cy="18" r="16" fill="none" stroke="#FAD6C7" stroke-width="4" class="opacity-60" />
                                                                <circle cx="18" cy="18" r="16" fill="none" stroke="#822021" stroke-width="4" stroke-linecap="round" stroke-dasharray="100" stroke-dashoffset="0" data-countdown-progress />
                                                            </svg>
                                                            <div class="absolute inset-0 flex items-center justify-center text-lg font-bold text-[#822021]" data-countdown-number>{{ $remainingSeconds }}</div>
                                                        </div>
                                                        <div class="space-y-2">
                                                            <h4 class="text-base font-semibold text-[#822021]">Segera unggah bukti pembayaran</h4>
                                                            <p class="text-sm text-[#822021]/70">Jika waktu habis, halaman otomatis dimuat ulang.</p>
                                                        </div>
                                                    </div>
                                                    <div class="relative h-2 overflow-hidden rounded-full bg-[#FFDEF8]">
                                                        <div class="absolute inset-y-0 left-0 w-0 rounded-full bg-[#822021]" data-countdown-bar></div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Form Upload Bukti --}}
                                    <div>
                                        <div class="rounded-2xl md:rounded-[28px] border border-[#822021]/40 bg-[#FFDEF8]/50 px-4 md:px-6 py-4 md:py-6 shadow-inner">
                                            <form method="POST" action="{{ route('registrations.payment-proof', $registration) }}" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                                                @csrf
                                                <div>
                                                    <label for="payment_proof" class="block text-sm md:text-base font-bold text-[#822021]">Unggah Bukti Pembayaran</label>
                                                    <input type="file" id="payment_proof" name="payment_proof" class="sr-only" accept="image/*,.pdf" required data-proof-input>
                                                    <label for="payment_proof" class="mt-3 flex cursor-pointer flex-col items-center justify-center gap-4 rounded-2xl md:rounded-[24px] border border-dashed border-[#822021]/40 bg-white/80 px-4 md:px-6 py-8 md:py-10 text-center text-sm font-semibold text-[#822021] transition hover:bg-white">
                                                        <div data-proof-empty>
                                                            <p class="text-base md:text-lg font-bold">Klik untuk upload</p>
                                                            <p class="text-xs md:text-sm font-normal text-[#822021]/70">Format JPG, PNG, PDF • Maksimal 5MB</p>
                                                        </div>
                                                        <div class="hidden w-full text-[#822021]" data-proof-preview>
                                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">File dipilih</p>
                                                            <p class="mt-3 break-words text-sm font-semibold" data-proof-name>-</p>
                                                            <p class="text-xs font-medium text-[#822021]/70" data-proof-size></p>
                                                        </div>
                                                    </label>
                                                    @error('payment_proof')
                                                        <p class="mt-3 text-xs font-medium text-red-600">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                                    <a href="{{ route('events.show', $registration->event) }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full border border-[#822021]/40 px-4 md:px-6 py-2 md:py-3 text-sm font-semibold text-[#822021] transition hover:bg-[#FFDEF8]">Batal</a>
                                                    
                                                    {{-- Button Lanjutkan: Style Baru --}}
                                                    <button type="submit" data-proof-submit disabled class="btn-action w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#FFDEF8] border border-[#822021] px-4 md:px-6 py-2 md:py-3 text-sm font-bold text-[#822021] shadow-md disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                                                        Lanjutkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Ringkasan Akhir --}}
                                <div id="konfirmasi" class="rounded-2xl md:rounded-[28px] border border-[#822021] bg-[#FAF8F1] px-4 md:px-6 py-4 md:py-6 shadow-inner text-sm">
                                    <h3 class="text-base md:text-lg font-bold text-[#822021]">Detail Pembayaran</h3>
                                    <dl class="mt-4 space-y-2">
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#822021]/70">Status</dt>
                                            <dd class="font-bold text-[#822021]">{{ $paymentStatus?->label() }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#822021]/70">Nominal</dt>
                                            <dd class="font-bold text-[#822021]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#822021]/70">Metode</dt>
                                            <dd class="font-semibold text-[#822021]">{{ $paymentMethod }}</dd>
                                        </div>
                                        @if ($transaction?->paid_at)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#822021]/70">Dibayar</dt>
                                                <dd class="text-[#822021]">{{ $transaction->paid_at->translatedFormat('d F Y H:i') }}</dd>
                                            </div>
                                        @endif
                                        @if ($transaction?->payment_proof_path)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#822021]/70">Bukti</dt>
                                                <dd>
                                                    <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="btn-action inline-flex items-center gap-2 rounded-full bg-[#822021] px-3 py-1 text-xs font-semibold text-[#FCF5E6] shadow-sm">
                                                        Lihat Bukti
                                                    </a>
                                                </dd>
                                            </div>
                                        @endif
                                    </dl>
                                </div>
                            @endif
                        </div>
                    </div>

                    <aside class="space-y-4 md:space-y-6">
                        {{-- Ringkasan Event Kanan --}}
                        <div class="rounded-2xl md:rounded-[32px] border border-[#822021] bg-[#FAF8F1] p-4 md:p-6 shadow-lg shadow-[#822021]/10 backdrop-blur">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#822021]/60">Informasi Event</p>
                            <h2 class="mt-2 text-lg md:text-xl font-bold text-[#822021]">{{ $registration->event->title }}</h2>
                            <p class="mt-1 text-sm text-[#822021]/80 leading-relaxed">
                                {{ Str::limit(strip_tags($registration->event->description ?? ''), 120) ?: 'Detail event akan diinformasikan.' }}
                            </p>
                            
                            {{-- Info Singkat Kanan --}}
                            <div class="mt-4 space-y-3 md:space-y-4 text-sm">
                                <dl class="space-y-3">
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#822021]/70">Tanggal</dt>
                                        <dd class="text-right text-[#822021] font-semibold">{{ $registration->event->start_at->translatedFormat('d F Y') }}</dd>
                                    </div>
                                    {{-- ... (Item ringkasan lain sama, warna disesuaikan) ... --}}
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#822021]/70">Nominal</dt>
                                        <dd class="text-right font-bold text-[#822021]">
                                            Rp{{ number_format($registration->event->price, 0, ',', '.') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </section>

    @if (! $showTicket)
        @push('scripts')
        <script>
        // Script Countdown & File Upload (Tidak berubah logic-nya, hanya style visual)
        document.addEventListener('DOMContentLoaded', () => {
            const timerEl = document.querySelector('[data-payment-timer]');
            if (timerEl) {
                const totalSeconds = Math.max(0, Number(timerEl.dataset.seconds ?? 0));
                const bar = timerEl.querySelector('[data-countdown-bar]');
                const number = timerEl.querySelector('[data-countdown-number]');
                const label = timerEl.querySelector('[data-countdown-label]');
                const progress = timerEl.querySelector('[data-countdown-progress]');
                const eventUrl = timerEl.dataset.eventUrl;
                const expireUrl = timerEl.dataset.expireUrl;
                const csrf = document.querySelector('meta[name="csrf-token"]')?.content;
                let remaining = totalSeconds;
                let isExpiring = false;
                let intervalId = null;

                const formatTime = (value) => {
                    const m = Math.floor(value / 60).toString().padStart(2, '0');
                    const s = (value % 60).toString().padStart(2, '0');
                    return `${m}:${s}`;
                };
                
                const cleanupAndRedirect = () => { window.location.href = eventUrl || '/events'; };
                
                const expireRegistration = async () => {
                    if (isExpiring) return;
                    isExpiring = true;
                    if (intervalId) clearInterval(intervalId);
                    if (!expireUrl || !csrf) { cleanupAndRedirect(); return; }
                    try {
                        const response = await fetch(expireUrl, {
                            method: 'POST',
                            headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' },
                        });
                        if (!response.ok) { cleanupAndRedirect(); return; }
                        const data = await response.json();
                        window.location.href = data.redirect || eventUrl || '/events';
                    } catch (error) { cleanupAndRedirect(); }
                };

                const render = () => {
                    const baseSeconds = totalSeconds || 1;
                    const percent = Math.max(0, Math.min(100, baseSeconds === 0 ? 0 : (remaining / baseSeconds) * 100));
                    if (bar) bar.style.width = `${100 - percent}%`;
                    if (number) number.textContent = remaining;
                    if (label) label.textContent = formatTime(remaining);
                    if (progress) progress.style.strokeDashoffset = (100 - percent).toString();
                };

                const startCountdown = () => {
                    render();
                    if (remaining <= 0) {
                        expireRegistration();
                        return;
                    }

                    intervalId = setInterval(() => {
                        remaining -= 1;
                        if (remaining <= 0) {
                            expireRegistration();
                            return;
                        }
                        render();
                    }, 1000);
                };

                startCountdown();
            }

            // File Upload Logic
            const input = document.querySelector('[data-proof-input]');
            const submit = document.querySelector('[data-proof-submit]');
            const emptyState = document.querySelector('[data-proof-empty]');
            const previewState = document.querySelector('[data-proof-preview]');
            const fileNameEl = document.querySelector('[data-proof-name]');
            const fileSizeEl = document.querySelector('[data-proof-size]');

            if (!input || !submit) return;

            const formatBytes = (bytes) => {
                if (!Number.isFinite(bytes) || bytes <= 0) return '';
                const units = ['B', 'KB', 'MB', 'GB'];
                const exponent = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
                return `${(bytes / 1024 ** exponent).toFixed(exponent === 0 ? 0 : 1)} ${units[exponent]}`;
            };

            const toggle = () => {
                const file = input.files[0] ?? null;
                submit.disabled = !file;

                if (!emptyState || !previewState || !fileNameEl || !fileSizeEl) return;

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
