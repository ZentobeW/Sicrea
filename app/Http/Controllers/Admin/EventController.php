<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Ambil kata kunci pencarian
        $search = $request->input('search'); // Gunakan input() agar dapat null/string biasa

        $events = Event::query()
            ->withCount([
                'registrations as confirmed_registrations_count' => fn ($query) => $query->where('status', RegistrationStatus::Confirmed),
                'registrations as total_registrations_count',
            ])
            // 2. Filter Query
            ->when($search, function ($query, $keyword) {
                $query->where(function ($builder) use ($keyword) {
                    $builder->where('title', 'like', "%{$keyword}%")
                        ->orWhere('venue_name', 'like', "%{$keyword}%")
                        ->orWhere('venue_address', 'like', "%{$keyword}%")
                        ->orWhere('tutor_name', 'like', "%{$keyword}%");
                });
            })
            ->orderByDesc('start_at')
            ->paginate(10)
            ->withQueryString(); // Penting: Simpan filter saat pindah halaman (pagination)

        $overview = [
            'total' => Event::count(),
            'published' => Event::where('status', EventStatus::Published)->count(),
            'drafts' => Event::where('status', EventStatus::Draft)->count(),
        ];

        $nextEvent = Event::query()
            ->where('status', EventStatus::Published)
            ->where('start_at', '>=', now())
            ->orderBy('start_at')
            ->first();

        // 3. Kirim data filter ke View agar input tidak kosong setelah reload
        $filters = [
            'search' => $search,
        ];

        return view('admin.events.index', compact('events', 'overview', 'nextEvent', 'filters'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $event = Event::create(array_merge(
                $request->validated(),
                [
                    'created_by' => $request->user()->id,
                    'status' => $request->boolean('publish') ? EventStatus::Published : EventStatus::Draft,
                    'published_at' => $request->boolean('publish') ? now() : null,
                ]
            ));

            if ($request->boolean('publish')) {
                $event->update(['published_at' => now()]);
            }
        });

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil dibuat.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update(array_merge(
            $request->validated(),
            [
                'updated_by' => $request->user()->id,
                'status' => $request->boolean('publish') ? EventStatus::Published : EventStatus::Draft,
                'published_at' => $request->boolean('publish') ? ($event->published_at ?? now()) : null,
            ]
        ));

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil dihapus.');
    }
}