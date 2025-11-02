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

class PortfolioController extends Controller
{
    public function index(Request $request): View
    {
        $portfoliosQuery = Portfolio::query()
            ->with('event')
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%' . $request->string('q')->toString() . '%'))
            ->when($request->filled('event_id'), fn ($query) => $query->where('event_id', $request->integer('event_id')))
            ->latest();

        $portfolios = $portfoliosQuery->paginate(12)->withQueryString();

        $insight = [
            'total' => Portfolio::count(),
            'linked' => Portfolio::whereNotNull('event_id')->count(),
        ];

        $latestUpdate = Portfolio::latest('updated_at')->first();

        $events = Event::orderBy('start_at')->orderBy('title')->get(['id', 'title']);

        $filters = [
            'q' => $request->string('q')->toString(),
            'event_id' => $request->integer('event_id'),
        ];

        return view('admin.portfolios.index', compact('portfolios', 'insight', 'latestUpdate', 'events', 'filters'));
    }

    public function create(): View
    {
        $events = Event::orderBy('title')->get();

        return view('admin.portfolios.create', compact('events'));
    }

    public function store(StorePortfolioRequest $request): RedirectResponse
    {
        Portfolio::create($request->validated());

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio): View
    {
        $events = Event::orderBy('title')->get();

        return view('admin.portfolios.edit', compact('portfolio', 'events'));
    }

    public function update(UpdatePortfolioRequest $request, Portfolio $portfolio): RedirectResponse
    {
        $portfolio->update($request->validated());

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio diperbarui.');
    }

    public function destroy(Portfolio $portfolio): RedirectResponse
    {
        $portfolio->delete();

        return redirect()->route('admin.portfolios.index')->with('status', 'Portofolio dihapus.');
    }
}
