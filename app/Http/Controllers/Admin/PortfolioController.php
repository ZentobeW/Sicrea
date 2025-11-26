<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Event;
use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        // 1. Ambil nilai filter dari Request
        $searchQuery = $request->input('q');
        $eventId = $request->input('event_id');

        $portfoliosQuery = Portfolio::query()
            ->with([
                'event:id,title,start_at,venue_name,venue_address,tutor_name',
                'images' => fn ($query) => $query->orderBy('display_order')->orderBy('id'),
            ])
            // 2. Filter Pencarian Teks
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $keyword = '%' . $searchQuery . '%';
                $query->where(function ($builder) use ($keyword) {
                    $builder
                        ->where('title', 'like', $keyword)
                        ->orWhereHas('event', function ($eventQuery) use ($keyword) {
                            $eventQuery
                                ->where('title', 'like', $keyword)
                                ->orWhere('venue_name', 'like', $keyword)
                                ->orWhere('venue_address', 'like', $keyword)
                                ->orWhere('tutor_name', 'like', $keyword);
                        });
                });
            })
            // 3. Filter Dropdown Event
            ->when($eventId, fn ($query) => $query->where('event_id', $eventId))
            ->latest();

        $portfolios = $portfoliosQuery->paginate(12)->withQueryString();

        $insight = [
            'total' => Portfolio::count(),
            'linked' => Portfolio::whereNotNull('event_id')->count(),
        ];

        $latestUpdate = Portfolio::latest('updated_at')->first();

        $events = Event::orderBy('start_at')->orderBy('title')->get(['id', 'title']);

        // 4. Kirim data filter kembali ke View
        $filters = [
            'q' => $searchQuery,
            'event_id' => $eventId,
        ];

        if ($request->ajax()) {
            return view('admin.portfolios.partials.list', compact('portfolios'));
        }

        return view('admin.portfolios.index', compact('portfolios', 'insight', 'latestUpdate', 'events', 'filters'));
    }

    // ... (method create, store, edit, update, destroy tetap sama seperti sebelumnya) ...
    public function create(): View
    {
        $events = Event::orderBy('title')->get();

        return view('admin.portfolios.create', compact('events'));
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        $data = $request->safe()->except('gallery');

        $portfolio = Portfolio::create($data);

        if ($request->hasFile('gallery')) {
            $this->storeGallery($portfolio, $request->file('gallery'));
        }

        $this->resequenceGallery($portfolio);

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $portfolio->load('event');
        $portfolio->load(['images' => fn ($query) => $query->orderBy('display_order')->orderBy('id')]);

        $events = Event::orderBy('title')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'events'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $data = $request->safe()->except(['gallery', 'remove_gallery']);

        $portfolio->update($data);

        $removeGallery = collect($request->input('remove_gallery', []))
            ->filter()
            ->map(fn ($value) => (int) $value);

        if ($removeGallery->isNotEmpty()) {
            $imagesToRemove = $portfolio->images()
                ->whereIn('id', $removeGallery->all())
                ->get();

            foreach ($imagesToRemove as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        if ($request->hasFile('gallery')) {
            $this->storeGallery($portfolio, $request->file('gallery'));
        }

        $this->resequenceGallery($portfolio);

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio diperbarui.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio dihapus.');
    }

    protected function storeGallery(Portfolio $portfolio, array $files): void
    {
        $currentMax = (int) $portfolio->images()->max('display_order');

        foreach ($files as $index => $file) {
            if (! $file) {
                continue;
            }

            $path = $file->store('portfolio-gallery', 'public');

            $portfolio->images()->create([
                'path' => $path,
                'display_order' => $currentMax + $index + 1,
            ]);
        }
    }

    protected function resequenceGallery(Portfolio $portfolio): void
    {
        $portfolio->images()
            ->orderBy('display_order')
            ->orderBy('id')
            ->get()
            ->values()
            ->each(function ($image, $index) {
                $image->update(['display_order' => $index + 1]);
            });
    }
}
