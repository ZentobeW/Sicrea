<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Ambil kata kunci pencarian
        $search = $request->input('search');

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
            ->orderBy('start_at', 'asc')
            ->paginate(10)
            ->withQueryString();

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

        // 3. Kirim data filter ke View
        $filters = [
            'search' => $search,
        ];

        if ($request->ajax()) {
            return view('admin.events.partials.table', compact('events', 'filters'));
        }

        return view('admin.events.index', compact('events', 'overview', 'nextEvent', 'filters'));
    }

    public function create(): View
    {
        return view('admin.events.create');
    }

    public function store(StoreEventRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $data = $request->validated();

            // Logika Upload Gambar Baru
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('events', 'public');
            }

            $event = Event::create(array_merge(
                $data,
                [
                    'created_by' => $request->user()->id,
                    'status' => $request->boolean('publish') ? EventStatus::Published : EventStatus::Draft,
                    'published_at' => $request->boolean('publish') ? now() : null,
                ]
            ));

            // Jika publish dicentang, update timestamp published_at
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
        $data = $request->validated();

        // Logika Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($event->image) {
                Storage::disk('public')->delete($event->image);
            }
            // Upload gambar baru
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update(array_merge(
            $data,
            [
                'updated_by' => $request->user()->id,
                'status' => $request->boolean('publish') ? EventStatus::Published : EventStatus::Draft,
                // Jangan reset published_at jika sudah ada, kecuali baru di-publish sekarang
                'published_at' => $request->boolean('publish') ? ($event->published_at ?? now()) : null,
            ]
        ));

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        // Hapus file gambar dari storage saat event dihapus
        if ($event->image) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil dihapus.');
    }
}