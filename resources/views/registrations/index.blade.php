<x-layouts.app :title="'Riwayat Workshop'">
    <h1 class="text-2xl font-semibold text-slate-800 mb-6">Riwayat Workshop Saya</h1>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-slate-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Workshop</th>
                    <th class="px-4 py-3 text-left">Jadwal</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Pembayaran</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($registrations as $registration)
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">{{ $registration->event->title }}</div>
                            <div class="text-xs text-slate-500">Rp{{ number_format($registration->amount, 0, ',', '.') }}</div>
                            <div class="text-[11px] text-slate-500">{{ $registration->event->venue_name }}</div>
                        </td>
                        <td class="px-4 py-3 text-slate-600">{{ optional($registration->event->start_at)->translatedFormat('d M Y H:i') }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-600">{{ $registration->status->label() }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">{{ $registration->payment_status->label() }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('registrations.show', $registration) }}" class="text-indigo-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-10 text-center text-slate-500">Belum ada riwayat pendaftaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $registrations->links() }}
    </div>
</x-layouts.app>
