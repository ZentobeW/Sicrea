@php
    use App\Enums\PaymentStatus;
    use Illuminate\Support\Facades\Storage;

    $transaction = $registration->transaction;
    $paymentStatus = $transaction?->status;
    $isAwaitingVerification = $paymentStatus === PaymentStatus::AwaitingVerification;
    $isVerified = $paymentStatus === PaymentStatus::Verified;
    $isRejected = $paymentStatus === PaymentStatus::Rejected;
    $isRefunded = $paymentStatus === PaymentStatus::Refunded;
    $currentStep = ($isAwaitingVerification || $isVerified || $isRefunded) ? 3 : 2;
    $steps = [
        ['label' => 'Data Peserta'],
        ['label' => 'Informasi Pembayaran'],
        ['label' => 'Konfirmasi'],
    ];
@endphp

<x-layouts.app :title="'Pembayaran Pendaftaran'">
    <section class="bg-gradient-to-br from-[#FFE3D3] via-[#FFF3EA] to-white py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('events.show', $registration->event) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#C65B74] hover:text-[#A2475D]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Detail Event
            </a>

            <div class="mt-6 grid gap-8 lg:grid-cols-[minmax(0,2fr),minmax(0,1fr)]">
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
                            <div class="rounded-[28px] border border-[#B4E0C4] bg-[#F1FBF2] px-6 py-5 shadow-inner">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#2F9A55]/10 text-[#2F9A55]">
                                        ✓
                                    </span>
                                    <div class="text-sm text-[#2F9A55]">
                                        <p class="font-semibold">Bukti pembayaran berhasil dikirim.</p>
                                        <p class="text-[#4D7B5F]">Tim admin kami sedang melakukan verifikasi. Mohon menunggu email konfirmasi selanjutnya.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif ($isVerified)
                            <div class="rounded-[28px] border border-[#B4E0C4] bg-[#F1FBF2] px-6 py-5 shadow-inner">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#2F9A55]/10 text-[#2F9A55]">
                                        ✓
                                    </span>
                                    <div class="text-sm text-[#2F9A55]">
                                        <p class="font-semibold">Pendaftaran berhasil.</p>
                                        <p class="text-[#4D7B5F]">Pembayaran Anda telah terverifikasi. Sampai bertemu di workshop!</p>
                                    </div>
                                </div>
                            </div>
                        @elseif ($isRefunded)
                            <div class="rounded-[28px] border border-[#FFE2CF] bg-[#FFF5EF] px-6 py-5 shadow-inner">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#FF8A64]/10 text-[#FF8A64]">
                                        ↺
                                    </span>
                                    <div class="text-sm text-[#C65B74]">
                                        <p class="font-semibold">Dana telah dikembalikan.</p>
                                        <p class="text-[#B87A7A]">Pengembalian dana sudah diproses oleh admin. Silakan cek rekening Anda secara berkala.</p>
                                    </div>
                                </div>
                            </div>
                        @elseif ($isRejected)
                            <div class="rounded-[28px] border border-[#FDE1E7] bg-[#FFF5F7] px-6 py-5 shadow-inner">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#BA1B1D]/10 text-[#BA1B1D]">!</span>
                                    <div class="text-sm text-[#BA1B1D]">
                                        <p class="font-semibold">Bukti pembayaran ditolak.</p>
                                        <p class="text-[#C65B74]">Silakan periksa kembali detail transfer dan unggah ulang bukti yang sesuai.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if (! $isAwaitingVerification && ! $isVerified && ! $isRefunded)
                            <div class="grid gap-6 md:grid-cols-2">
                                <div class="space-y-5">
                                    <div class="rounded-[28px] border border-[#FAD6C7] bg-[#FFF5EF] px-6 py-5 shadow-inner">
                                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-[#C65B74]">Informasi Pembayaran</p>
                                        @if ($paymentAccount)
                                            <h2 class="mt-2 text-xl font-semibold text-[#2C1E1E]">Transfer Bank {{ $paymentAccount['bank'] }}</h2>
                                            <dl class="mt-4 space-y-3 text-sm text-[#5F4C4C]">
                                                <div>
                                                    <dt class="text-[#A04E62]">Nomor Rekening</dt>
                                                    <dd class="text-lg font-semibold text-[#2C1E1E] tracking-[0.2em]">{{ $paymentAccount['number'] }}</dd>
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
                                        @else
                                            <p class="mt-2 text-sm text-[#5F4C4C]">Informasi rekening belum tersedia. Silakan hubungi admin untuk detail pembayaran.</p>
                                        @endif
                                    </div>

                                    <div class="rounded-[28px] border border-dashed border-[#FAD6C7]/80 bg-white/70 px-6 py-5 text-sm text-[#6F4F4F] shadow-sm">
                                        <h3 class="text-base font-semibold text-[#2C1E1E]">Petunjuk Pembayaran</h3>
                                        <ul class="mt-3 space-y-2 list-disc list-inside">
                                            <li>Transfer sesuai nominal tagihan: <span class="font-semibold text-[#C65B74]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</span>.</li>
                                            <li>Gunakan berita transfer “Workshop {{ $registration->event->title }}”.</li>
                                            <li>Unggah bukti pembayaran untuk verifikasi admin.</li>
                                        </ul>
                                    </div>
                                </div>

                                <div>
                                    <div class="rounded-[28px] border border-[#FAD6C7] bg-white/90 px-6 py-6 shadow-inner">
                                        <form method="POST" action="{{ route('registrations.payment-proof', $registration) }}" enctype="multipart/form-data" class="space-y-6">
                                            @csrf
                                            <div>
                                                <label class="block text-sm font-semibold text-[#2C1E1E]">Unggah Bukti Pembayaran</label>
                                                <label class="mt-3 flex cursor-pointer flex-col items-center justify-center gap-2 rounded-[24px] border border-dashed border-[#FAD6C7] bg-[#FFF5EF] px-6 py-10 text-center text-sm font-semibold text-[#C65B74] shadow-inner transition hover:bg-[#FFE8DB]">
                                                    <input type="file" name="payment_proof" class="hidden" accept="image/*,.pdf" required>
                                                    <span class="text-base">Klik untuk upload</span>
                                                    <span class="text-xs font-normal text-[#B87A7A]">Format JPG, PNG, atau PDF • Maksimal 5MB</span>
                                                </label>
                                            </div>

                                            <div class="flex flex-wrap items-center justify-between gap-3">
                                                <a href="{{ route('events.show', $registration->event) }}" class="inline-flex items-center justify-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74] transition hover:-translate-y-0.5 hover:bg-[#FFF0E6]">Batal</a>
                                                <button class="inline-flex items-center justify-center gap-2 rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:-translate-y-0.5 hover:bg-[#F9744B]">
                                                    Lanjutkan
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="rounded-[28px] border border-[#FAD6C7] bg-white/90 px-6 py-6 shadow-inner text-sm text-[#6F4F4F]">
                                <h3 class="text-base font-semibold text-[#2C1E1E]">Detail Pembayaran</h3>
                                <dl class="mt-4 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <dt class="text-[#A04E62]">Status</dt>
                                        <dd class="font-semibold text-[#C65B74]">{{ $paymentStatus?->label() ?? 'Menunggu Pembayaran' }}</dd>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <dt class="text-[#A04E62]">Nominal</dt>
                                        <dd class="font-semibold text-[#2C1E1E]">Rp{{ number_format($transaction?->amount ?? $registration->event->price, 0, ',', '.') }}</dd>
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
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </dd>
                                        </div>
                                    @endif
                                </dl>

                                <div class="mt-6 flex flex-wrap items-center gap-3">
                                    <a href="{{ route('registrations.index') }}" class="inline-flex items-center justify-center rounded-full border border-[#FAD6C7] px-6 py-3 text-sm font-semibold text-[#C65B74] transition hover:-translate-y-0.5 hover:bg-[#FFF0E6]">Lihat Riwayat</a>
                                    <a href="{{ route('events.index') }}" class="inline-flex items-center justify-center rounded-full bg-[#FF8A64] px-6 py-3 text-sm font-semibold text-white shadow-md shadow-[#FF8A64]/30 transition hover:-translate-y-0.5 hover:bg-[#F9744B]">Kembali ke Events</a>
                                </div>

                                @if ($isVerified)
                                    <div class="mt-6 rounded-[24px] border border-dashed border-[#B4E0C4] bg-[#F1FBF2] px-5 py-5 text-sm text-[#2F9A55]">
                                        <h4 class="text-base font-semibold text-[#2F9A55]">Ajukan Refund</h4>
                                        @if ($transaction?->refund)
                                            <p class="mt-2 text-[#4D7B5F]">Status refund: <span class="font-semibold">{{ $transaction->refund->status->label() }}</span>.</p>
                                            @if ($transaction->refund->reason)
                                                <p class="mt-2 rounded-2xl border border-[#B4E0C4]/60 bg-white/80 px-4 py-3 text-[#4D7B5F]">{{ $transaction->refund->reason }}</p>
                                            @endif
                                        @else
                                            <p class="mt-2 text-[#4D7B5F]">Tidak dapat hadir? Sampaikan alasanmu, dan tim admin akan membantu proses refund.</p>
                                            <form method="POST" action="{{ route('registrations.refund.store', $registration) }}" class="mt-4 space-y-3">
                                                @csrf
                                                <textarea name="reason" rows="3" class="w-full rounded-2xl border border-[#B4E0C4] bg-white/80 px-4 py-3 text-sm text-[#2C1E1E] placeholder:text-[#6F8F7C] focus:border-[#2F9A55] focus:outline-none focus:ring-2 focus:ring-[#2F9A55]/30" placeholder="Ceritakan alasan pengembalian dana" required>{{ old('reason') }}</textarea>
                                                <button class="inline-flex items-center justify-center gap-2 rounded-full bg-[#2F9A55] px-5 py-2 text-sm font-semibold text-white shadow-md shadow-[#2F9A55]/30 transition hover:-translate-y-0.5 hover:bg-[#267846]">
                                                    Kirim Permintaan Refund
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @endif
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
                                    <dd class="text-right">{{ $registration->event->start_at->translatedFormat('H:i') }} - {{ $registration->event->end_at->translatedFormat('H:i') }} WIB</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Venue</dt>
                                    <dd class="text-right">
                                        <span class="block font-semibold text-[#2C1E1E]">{{ $registration->event->venue_name }}</span>
                                        <span class="block text-xs text-[#5F4C4C]">{{ $registration->event->venue_address }}</span>
                                    </dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Pemateri</dt>
                                    <dd class="text-right">{{ $registration->event->tutor_name }}</dd>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <dt class="text-[#A04E62]">Nominal</dt>
                                    <dd class="text-right font-semibold text-[#C65B74]">Rp{{ number_format($registration->event->price, 0, ',', '.') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="rounded-[28px] border border-dashed border-[#FAD6C7]/80 bg-white/70 p-6 text-sm text-[#5F4C4C] shadow-sm shadow-[#FAD6C7]/40">
                        <h3 class="text-base font-semibold text-[#2C1E1E]">Butuh Bantuan?</h3>
                        <p class="mt-2 text-sm text-[#6F4F4F]">Hubungi admin Kreasi Hangat melalui email <span class="font-semibold text-[#C65B74]">support@kreasihangat.com</span> bila mengalami kendala pembayaran.</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</x-layouts.app>
