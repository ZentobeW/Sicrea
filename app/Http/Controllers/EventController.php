<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()
            ->where('status', EventStatus::Published)
            ->when($request->string('q'), function ($query, string $keyword) {
                $query->where(function ($builder) use ($keyword) {
                    $builder
                        ->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('location', 'like', "%{$keyword}%");
                });
            })
            ->orderBy('start_at')
            ->paginate(9)
            ->withQueryString();

        return view('events.index', compact('events'));
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->where('slug', $slug)
            ->where('status', EventStatus::Published)
            ->with(['portfolios'])->withCount('registrations')
            ->firstOrFail();

        return view('events.show', compact('event'));
    }

    public function publish(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        if (! $event->isPublished()) {
            $event->update([
                'status' => EventStatus::Published,
                'published_at' => now(),
            ]);
        }

        return back()->with('status', 'Event berhasil dipublikasikan.');
    }

    public function unpublish(Event $event): RedirectResponse
    {
        $this->authorize('update', $event);

        if ($event->isPublished()) {
            $event->update([
                'status' => EventStatus::Draft,
                'published_at' => null,
            ]);
        }

        return back()->with('status', 'Event diubah menjadi draft.');
    }
}
