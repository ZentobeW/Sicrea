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
@endphp

<x-layouts.app :title="'Pembayaran Pendaftaran'">
    <style>
        .font-title { font-family: 'Cousine', monospace; }
        .font-body { font-family: 'Open Sans', sans-serif; }
    </style>
    <section class="bg-gradient-to-br from-[#FFBE8E] to-[#FCF5E6] py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4 md:space-y-6">
            <a href="{{ route('profile.show') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:text-[#B49F9A] font-body transition-colors">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Profil
            </a>

            @if ($showTicket)
                <div id="tiket" class="space-y-4 md:space-y-6">
                    <div class="text-center md:text-left">
                        <p class="text-s md:text-sm font-semibold uppercase tracking-[0.3em] text- [#822021] font-body">Detail Tiket Event</p>
                        <p class="mt-2 max-w-2xl text-sm md:text-base text-[#B49F9A] font-body">Lihat tiket, status pembayaran, dan ajukan refund jika berhalangan hadir.</p>
                    </div>

                    <div class="grid gap-4 md:gap-6 lg:grid-cols-2 lg:items-start">
                        <div class="space-y-4 md:space-y-6">
                            <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/95 p-4 md:p-6 shadow-xl shadow-[#FFB3E1]/20 backdrop-blur">
                                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Informasi Event</p>
                                        <h2 class="mt-2 text-xl md:text-2xl font-bold text-[#822021] font-title">{{ $registration->event->title }}</h2>
                                        <p class="mt-1 text-sm md:text-base text-[#B49F9A] font-body leading-relaxed">
                                            {{ Str::limit(strip_tags($registration->event->description ?? ''), 120) ?: 'Detail event akan diinformasikan.' }}
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4 grid gap-3 grid-cols-1 sm:grid-cols-2">
                                    <div class="rounded-xl md:rounded-2xl bg-[#FCF5E6] px-3 py-2.5 border border-[#FFDEF8]">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Tanggal</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021] font-body">{{ optional($registration->event->start_at)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FCF5E6] px-3 py-2.5 border border-[#FFDEF8]">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Waktu</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021] font-body">
                                            {{ optional($registration->event->start_at)->translatedFormat('H:i') }} - {{ optional($registration->event->end_at)->translatedFormat('H:i') }} WIB
                                        </p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FCF5E6] px-3 py-2.5 border border-[#FFDEF8]">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Tempat</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021] font-body">{{ $registration->event->venue_name }}</p>
                                        <p class="text-xs text-[#B49F9A] font-body mt-0.5">{{ $registration->event->venue_address }}</p>
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl bg-[#FCF5E6] px-3 py-2.5 border border-[#FFDEF8]">
                                        <p class="text-[10px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Harga</p>
                                        <p class="mt-1 text-sm font-bold text-[#822021] font-body">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</p>
                                        <p class="text-xs text-[#B49F9A] font-body mt-0.5">ID: reg{{ $registration->id }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/95 p-4 md:p-6 shadow-xl shadow-[#FFB3E1]/20 backdrop-blur">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Informasi Mentor</p>
                                <div class="mt-3 rounded-xl md:rounded-2xl bg-[#FCF5E6] px-3 md:px-4 py-3 text-sm border border-[#FFDEF8]">
                                    <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Nama</p>
                                    <p class="mt-1 text-base md:text-lg font-bold text-[#822021] font-body">{{ $registration->event->tutor_name ?? 'Pengajar akan diumumkan' }}</p>
                                    <p class="mt-1 text-xs md:text-sm text-[#B49F9A] font-body">Pembimbing utama workshop.</p>
                                </div>
                            </div>
                        </div>

                        <aside class="flex flex-col space-y-4 md:space-y-6">
                            <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/90 p-4 md:p-6 shadow-lg shadow-[#FFB3E1]/20 backdrop-blur flex-1">
                                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Detail Pendaftaran</p>
                                <div class="mt-4 grid gap-3 md:gap-4 sm:grid-cols-2">
                                    <div class="rounded-xl md:rounded-2xl border border-[#FFDEF8] bg-[#FCF5E6] px-3 md:px-4 py-4 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Bukti Pembayaran</p>
                                        @if ($transaction?->payment_proof_path)
                                            <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 rounded-full bg-[#822021] px-3 md:px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#822021]/30 transition hover:bg-[#B49F9A] font-body">
                                                Lihat Bukti
                                            </a>
                                        @else
                                            <p class="mt-2 text-sm font-semibold text-[#822021] font-body">Belum ada bukti pembayaran.</p>
                                        @endif
                                    </div>
                                    <div class="rounded-xl md:rounded-2xl border border-[#FFDEF8] bg-[#FCF5E6] px-3 md:px-4 py-4 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Status</p>
                                        <span @class([
                                            'mt-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-semibold font-body',
                                            'bg-[#E4F5E9] text-[#2F9A55]' => $isVerified,
                                            'bg-[#FDE1E7] text-[#BA1B1D]' => $isRejected,
                                            'bg-[#FDF7D8] text-[#B89530]' => $isAwaitingVerification,
                                            'bg-[#E8F3FF] text-[#2B6CB0]' => $isRefunded,
                                        ])>
                                            {{ $paymentStatus?->label() ?? 'Tidak ada data' }}
                                        </span>
                                        @if ($transaction?->verified_at)
                                            <p class="mt-1 text-xs text-[#B49F9A] font-body">Terverifikasi: {{ $transaction->verified_at->translatedFormat('d F Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-4 rounded-xl md:rounded-2xl border border-[#FFDEF8] bg-white/80 px-3 md:px-4 py-4 text-sm">
                                    <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#46000D] font-body">Catatan</p>
                                    <p class="mt-2 text-sm md:text-base text-[#822021] font-body">Pembayaran sudah dikonfirmasi. Simpan tiket ini dan hadir tepat waktu.</p>
                                </div>
                            </div>

                            <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/90 p-4 md:p-6 shadow-lg shadow-[#FFB3E1]/20 backdrop-blur">
                                <div class="flex flex-wrap items-center justify-between gap-3">
                                    <div class="flex-1">
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#46000D] font-body">Pengajuan Refund</p>
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
                                            <a href="{{ route('registrations.refund.create', $registration) }}" class="inline-flex items-center gap-2 rounded-full bg-[#822021] px-3 md:px-4 py-2 text-xs font-semibold text-white shadow-md shadow-[#822021]/30 transition hover:bg-[#B49F9A] font-body">
                                                Ajukan Refund
                                            </a>
                                        @endcan
                                    @endif
                                </div>

                                <div class="mt-4 space-y-3 text-sm">
                                    <p class="font-bold text-[#822021] font-body">Syarat & Ketentuan:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs md:text-sm text-[#B49F9A] font-body">
                                        <li>Refund maksimal 3 hari sebelum event.</li>
                                        <li>Biaya admin 10% dari total.</li>
                                        <li>Proses 3-7 hari kerja setelah disetujui.</li>
                                    </ul>
                                </div>

                                @if ($refund)
                                    <div class="mt-4 rounded-xl md:rounded-2xl border border-dashed border-[#FFDEF8] bg-white/80 px-3 md:px-4 py-3 text-sm">
                                        <p class="text-[10px] md:text-[11px] font-semibold uppercase tracking-[0.3em] text-[#FFB3E1] font-body">Detail Refund</p>
                                        <p class="mt-2 text-sm md:text-base text-[#822021] font-body">Alasan: {{ $refund->reason }}</p>
                                        <p class="text-xs md:text-sm text-[#B49F9A] font-body">Diajukan: {{ optional($refund->requested_at)->translatedFormat('d F Y H:i') ?? '-' }}</p>
                                    </div>
                                @else
                                    @cannot('requestRefund', $registration)
                                        <p class="mt-4 text-sm font-semibold text-[#822021] font-body">Refund tersedia setelah pembayaran terverifikasi.</p>
                                    @endcannot
                                @endif
                            </div>
                        </aside>
                    </div>
                </div>
            @else
                <div id="tiket" class="grid gap-4 md:gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
                    <div class="rounded-2xl md:rounded-[32px] border border-[#FFDEF8] bg-white/95 p-4 md:p-6 lg:p-8 shadow-xl shadow-[#FFB3E1]/20 backdrop-blur">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div class="text-center md:text-left">
                                <p class="text-xs md:text-sm font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Step Pendaftaran</p>
                                <h1 class="mt-2 text-xl md:text-2xl lg:text-3xl font-bold text-[#822021] font-title">
                                    {{ $currentStep === 3 ? 'Konfirmasi Pembayaran' : 'Informasi Pembayaran' }}
                                </h1>
                            </div>
                            <div class="flex items-center justify-center md:justify-start gap-2 text-sm font-semibold text-[#822021] font-body">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#FFBE8E] text-white font-bold">{{ $currentStep }}</span>
                                <span>Langkah {{ $currentStep }} dari 3</span>
                            </div>
                        </div>

                        <div class="mt-4 md:mt-6 grid gap-2 md:gap-3 grid-cols-1 sm:grid-cols-3">
                            @foreach ($steps as $index => $step)
                                @php($stepNumber = $index + 1)
                                <div @class([
                                    'rounded-xl md:rounded-2xl px-3 md:px-4 py-2 md:py-3 text-xs md:text-sm font-semibold transition text-center font-body',
                                    'border border-[#FFDEF8] bg-[#FCF5E6] text-[#822021]' => $stepNumber <= $currentStep,
                                    'border border-dashed border-[#FFDEF8]/70 text-[#B49F9A]' => $stepNumber > $currentStep,
                                ])>
                                    {{ $step['label'] }}
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 md:mt-8 space-y-6 md:space-y-8">
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
                                        <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-[#FCF5E6] px-4 md:px-6 py-4 md:py-5 shadow-inner">
                                            <p class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Informasi Pembayaran</p>
                                            <p class="text-[10px] md:text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body mt-2">Metode Pembayaran</p>
                                            <p class="mt-1 text-sm md:text-base font-bold text-[#822021] font-body">{{ $paymentMethod }}</p>

                                            @if ($paymentAccount)
                                                <h2 class="mt-2 text-lg md:text-xl font-bold text-[#822021] font-title">Virtual Account {{ $paymentAccount['bank'] }}</h2>
                                                <dl class="mt-4 space-y-3 text-sm md:text-base">
                                                    <div>
                                                        <dt class="text-[#B49F9A] font-body">Nomor Rekening</dt>
                                                        <dd class="text-base md:text-lg font-bold tracking-[0.2em] text-[#822021] font-title">{{ $paymentAccount['number'] }}</dd>
                                                    </div>
                                                    <div>
                                                        <dt class="text-[#B49F9A] font-body">Atas Nama</dt>
                                                        <dd class="font-semibold text-[#822021] font-body">{{ $paymentAccount['name'] }}</dd>
                                                    </div>
                                                    @if (! empty($paymentAccount['branch']))
                                                        <div>
                                                            <dt class="text-[#B49F9A] font-body">Cabang</dt>
                                                            <dd class="font-body text-[#822021]">{{ $paymentAccount['branch'] }}</dd>
                                                        </div>
                                                    @endif
                                                </dl>
                                                @if (! empty($paymentAccount['notes']))
                                                    <p class="mt-4 rounded-xl md:rounded-2xl border border-dashed border-[#FFDEF8] bg-white/80 px-3 md:px-4 py-3 text-xs md:text-sm text-[#B49F9A] font-body">
                                                        {{ $paymentAccount['notes'] }}
                                                    </p>
                                                @endif
                                            @endif
                                        </div>

                                        <div class="rounded-2xl md:rounded-[28px] border border-dashed border-[#FFDEF8]/80 bg-white/70 px-4 md:px-6 py-4 md:py-5 text-sm shadow-sm">
                                            <h3 class="text-base md:text-lg font-bold text-[#822021] font-title">Petunjuk Pembayaran</h3>
                                            <ul class="mt-3 space-y-2 list-disc list-inside text-[#B49F9A] font-body">
                                                <li>Transfer sebesar <span class="font-bold text-[#822021]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</span></li>
                                                <li>Gunakan berita transfer "Workshop {{ $registration->event->title }}"</li>
                                                <li>Unggah bukti pembayaran melalui form di samping</li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/90 px-4 md:px-6 py-4 md:py-6 shadow-inner">
                                            <form method="POST" action="{{ route('registrations.payment-proof', $registration) }}" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
                                                @csrf
                                                <div>
                                                    <label for="payment_proof" class="block text-sm md:text-base font-bold text-[#822021] font-body">Unggah Bukti Pembayaran</label>
                                                    <input type="file" id="payment_proof" name="payment_proof" class="sr-only" accept="image/*,.pdf" required data-proof-input>
                                                    <label for="payment_proof" class="mt-3 flex cursor-pointer flex-col items-center justify-center gap-4 rounded-2xl md:rounded-[24px] border border-dashed border-[#FFDEF8] bg-[#FCF5E6] px-4 md:px-6 py-8 md:py-10 text-center text-sm font-semibold text-[#822021] shadow-inner transition hover:bg-[#FFDEF8] font-body">
                                                        <div data-proof-empty>
                                                            <p class="text-base md:text-lg font-bold">Klik untuk upload</p>
                                                            <p class="text-xs md:text-sm font-normal text-[#B49F9A]">Format JPG, PNG, PDF • Maksimal 5MB</p>
                                                        </div>
                                                        <div class="hidden w-full text-[#822021]" data-proof-preview>
                                                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A]">File dipilih</p>
                                                            <p class="mt-3 break-words text-sm font-semibold" data-proof-name>-</p>
                                                            <p class="text-xs font-medium text-[#B49F9A]" data-proof-size></p>
                                                        </div>
                                                    </label>
                                                    @error('payment_proof')
                                                        <p class="mt-3 text-xs font-medium text-[#BA1B1D]">{{ $message }}</p>
                                                    @enderror
                                                </div>

                                                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                                                    <a href="{{ route('events.show', $registration->event) }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full border border-[#FFDEF8] px-4 md:px-6 py-2 md:py-3 text-sm font-semibold text-[#822021] transition hover:bg-[#FCF5E6] font-body">Batal</a>
                                                    <button type="submit" data-proof-submit disabled class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-full bg-[#FFBE8E] px-4 md:px-6 py-2 md:py-3 text-sm font-semibold text-white shadow-md shadow-[#FFBE8E]/30 transition hover:bg-[#822021] disabled:bg-[#B49F9A] disabled:text-white/60 disabled:cursor-not-allowed font-body">
                                                        Lanjutkan
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div id="konfirmasi" class="rounded-2xl md:rounded-[28px] border border-[#FFDEF8] bg-white/90 px-4 md:px-6 py-4 md:py-6 shadow-inner text-sm">
                                    <h3 class="text-base md:text-lg font-bold text-[#822021] font-title">Detail Pembayaran</h3>
                                    <dl class="mt-4 space-y-2 font-body">
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#B49F9A]">Status</dt>
                                            <dd class="font-bold text-[#822021]">{{ $paymentStatus?->label() }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#B49F9A]">Nominal</dt>
                                            <dd class="font-bold text-[#822021]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</dd>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <dt class="text-[#B49F9A]">Metode</dt>
                                            <dd class="font-semibold text-[#822021]">{{ $paymentMethod }}</dd>
                                        </div>
                                        @if ($transaction?->paid_at)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#B49F9A]">Dibayar</dt>
                                                <dd class="text-[#822021]">{{ $transaction->paid_at->translatedFormat('d F Y H:i') }}</dd>
                                            </div>
                                        @endif
                                        @if ($transaction?->payment_proof_path)
                                            <div class="flex items-center justify-between">
                                                <dt class="text-[#B49F9A]">Bukti</dt>
                                                <dd>
                                                    <a href="{{ Storage::disk('public')->url($transaction->payment_proof_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-[#822021] hover:text-[#B49F9A]">
                                                        Lihat Bukti
                                                    </a>
                                                </dd>
                                            </div>
                                        @endif
                                    </dl>
                                    <!-- <div class="mt-6 flex flex-col sm:flex-row items-center gap-3">
                                        <a href="{{ route('registrations.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full border border-[#FFDEF8] px-4 md:px-6 py-2 md:py-3 text-sm font-semibold text-[#822021] font-body">Lihat Riwayat</a>
                                        <a href="{{ route('events.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center rounded-full bg-[#FFBE8E] px-4 md:px-6 py-2 md:py-3 text-sm font-semibold text-white shadow-md shadow-[#FFBE8E]/30 font-body">Kembali ke Events</a>
                                    </div> -->
                                </div>
                            @endif
                        </div>
                    </div>

                    <aside class="space-y-4 md:space-y-6">
                        <div class="rounded-2xl md:rounded-[32px] border border-[#FFDEF8] bg-white/85 p-4 md:p-6 shadow-lg shadow-[#FFB3E1]/20 backdrop-blur">
                            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#B49F9A] font-body">Informasi Event</p>
                            <h2 class="mt-2 text-lg md:text-xl font-bold text-[#822021] font-title">{{ $registration->event->title }}</h2>
                            <p class="mt-1 text-sm text-[#B49F9A] font-body leading-relaxed">
                                {{ Str::limit(strip_tags($registration->event->description ?? ''), 120) ?: 'Detail event akan diinformasikan.' }}
                            </p>
                            <div class="mt-4 space-y-3 md:space-y-4 text-sm">
                                <dl class="space-y-3 font-body">
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#B49F9A]">Tanggal</dt>
                                        <dd class="text-right text-[#822021] font-semibold">{{ $registration->event->start_at->translatedFormat('d F Y') }}</dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#B49F9A]">Waktu</dt>
                                        <dd class="text-right text-[#822021] font-semibold">
                                            {{ $registration->event->start_at->translatedFormat('H:i') }} -
                                            {{ $registration->event->end_at->translatedFormat('H:i') }} WIB
                                        </dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#B49F9A]">Venue</dt>
                                        <dd class="text-right">
                                            <span class="font-bold text-[#822021]">{{ $registration->event->venue_name }}</span>
                                            <span class="block text-xs text-[#B49F9A]">{{ $registration->event->venue_address }}</span>
                                        </dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#B49F9A]">Pemateri</dt>
                                        <dd class="text-right text-[#822021] font-semibold">{{ $registration->event->tutor_name }}</dd>
                                    </div>
                                    <div class="flex items-start justify-between gap-3">
                                        <dt class="text-[#B49F9A]">Nominal</dt>
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
        document.addEventListener('DOMContentLoaded', () => {
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