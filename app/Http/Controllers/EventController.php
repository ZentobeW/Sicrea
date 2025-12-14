<?php

namespace App\Http\Controllers;

use App\Enums\EventStatus;
use App\Enums\PaymentStatus;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::query()
            ->withCount([
                'registrations as confirmed_registrations_count' => fn ($query) => $query
                    ->where('status', RegistrationStatus::Confirmed),
                'registrations as verified_registrations_count' => fn ($query) => $query
                    ->where(function ($query) {
                        $query->where('status', RegistrationStatus::Confirmed->value)
                            ->orWhereHas('transaction', function ($transactionQuery) {
                                $transactionQuery->where('status', PaymentStatus::Verified->value);
                            });
                    }),
                'registrations as total_registrations_count',
            ])
            ->where('status', EventStatus::Published)

            // --- TAMBAHAN: Hanya tampilkan event yang belum lewat ---
            ->where('start_at', '>=', now())

            // Filter Pencarian (Search)
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = '%' . $request->string('q') . '%';
                $query->where(function ($builder) use ($keyword) {
                    $builder
                        ->where('title', 'like', $keyword)
                        ->orWhere('venue_name', 'like', $keyword)
                        ->orWhere('venue_address', 'like', $keyword)
                        ->orWhere('tutor_name', 'like', $keyword);
                });
            })

            // Urutkan dari yang paling dekat tanggalnya (Ascending)
            ->orderBy('start_at', 'asc')

            ->paginate(9)
            ->withQueryString();

        return view('events.index', compact('events'));
    }

    // Method show, publish, unpublish tetap sama seperti sebelumnya...
    public function show(Event $event): View
    {
        abort_unless($event->status === EventStatus::Published, 404);

        $event->loadMissing([
            'portfolios.images',
            'creator',
        ])->loadCount([
            'registrations',
            'registrations as verified_registrations_count' => function ($query) {
                $query->where(function ($query) {
                    $query->where('status', RegistrationStatus::Confirmed->value)
                        ->orWhereHas('transaction', function ($transactionQuery) {
                            $transactionQuery->where('status', PaymentStatus::Verified->value);
                        });
                });
            },
        ]);

        $existingRegistration = auth()->check()
            ? $event->registrations()
                ->where('user_id', auth()->id())
                ->latest('registered_at')
                ->first()
            : null;

        return view('events.show', compact('event', 'existingRegistration'));
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
