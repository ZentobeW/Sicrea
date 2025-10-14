<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePortfolioRequest;
use App\Http\Requests\UpdatePortfolioRequest;
use App\Models\Event;
use App\Models\Portfolio;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $portfolios = Portfolio::query()->with('event')->latest()->paginate(20);

        return view('admin.portfolios.index', compact('portfolios'));
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
