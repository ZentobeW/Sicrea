<?php

namespace App\Http\Controllers\Admin;

use App\Enums\EventStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->latest('start_at')
            ->paginate(15);

        return view('admin.events.index', compact('events'));
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
