<x-layouts.app :title="'Riwayat Workshop'">
    
    {{-- Custom Style for Font --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body, h1, h2, h3, p, a, span, div, th, td {
            font-family: 'Poppins', sans-serif !important;
        }
    </style>

    {{-- Main Container with Background #FFDEF8 --}}
    <div class="min-h-screen bg-[#FFDEF8] py-8 md:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Page --}}
            <h1 class="text-2xl md:text-3xl font-bold text-[#822021] mb-6">Riwayat Workshop Saya</h1>

            {{-- Table Container: BG #FAF8F1, Border #822021 --}}
            <div class="bg-[#FAF8F1] rounded-2xl shadow-lg border border-[#822021] overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[#822021]/20 text-sm">
                        {{-- Table Header: BG #822021, Text #FCF5E6 --}}
                        <thead class="bg-[#822021] text-[#FCF5E6] uppercase text-xs font-semibold tracking-wider">
                            <tr>
                                <th class="px-6 py-4 text-left">Workshop</th>
                                <th class="px-6 py-4 text-left">Jadwal</th>
                                <th class="px-6 py-4 text-left">Status</th>
                                <th class="px-6 py-4 text-left">Pembayaran</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        
                        {{-- Table Body --}}
                        <tbody class="divide-y divide-[#822021]/20">
                            @forelse ($registrations as $registration)
                                <tr class="hover:bg-[#FFDEF8]/50 transition-colors duration-200">
                                    {{-- Kolom Workshop --}}
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-[#822021] text-base">{{ $registration->event->title }}</div>
                                        <div class="text-xs font-semibold text-[#822021]/80 mt-1">
                                            Rp{{ number_format(optional($registration->transaction)->amount ?? 0, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[11px] text-[#822021]/60 mt-0.5">
                                            {{ $registration->event->venue_name }}
                                        </div>
                                    </td>

                                    {{-- Kolom Jadwal --}}
                                    <td class="px-6 py-4 text-[#822021]">
                                        {{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}
                                    </td>

                                    {{-- Kolom Status --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex rounded-full bg-[#FFB3E1] border border-[#822021]/20 px-3 py-1 text-xs font-bold text-[#822021]">
                                            {{ $registration->status->label() }}
                                        </span>
                                    </td>

                                    {{-- Kolom Pembayaran --}}
                                    <td class="px-6 py-4">
                                        @php($transaction = $registration->transaction)
                                        <span class="inline-flex rounded-full bg-[#FFDEF8] border border-[#822021]/20 px-3 py-1 text-xs font-bold text-[#822021]">
                                            {{ $transaction?->status->label() ?? 'Belum Dibuat' }}
                                        </span>
                                    </td>

                                    {{-- Kolom Aksi --}}
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('registrations.show', $registration) }}" class="inline-block font-bold text-[#822021] underline decoration-[#822021]/40 hover:decoration-[#822021] hover:text-[#6a1a1b] transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-[#822021]/60 italic">
                                        Belum ada riwayat pendaftaran workshop.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 text-[#822021]">
                {{ $registrations->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>