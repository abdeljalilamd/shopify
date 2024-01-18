<?php

namespace App\Http\Controllers;

use App\Models\Taxe;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TaxeStoreRequest;
use App\Http\Requests\TaxeUpdateRequest;

class TaxeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Taxe::class);

        $search = $request->get('search', '');

        $taxes = Taxe::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.taxes.index', compact('taxes', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Taxe::class);

        return view('app.taxes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaxeStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Taxe::class);

        $validated = $request->validated();

        $taxe = Taxe::create($validated);

        return redirect()
            ->route('taxes.edit', $taxe)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Taxe $taxe): View
    {
        $this->authorize('view', $taxe);

        return view('app.taxes.show', compact('taxe'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Taxe $taxe): View
    {
        $this->authorize('update', $taxe);

        return view('app.taxes.edit', compact('taxe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TaxeUpdateRequest $request,
        Taxe $taxe
    ): RedirectResponse {
        $this->authorize('update', $taxe);

        $validated = $request->validated();

        $taxe->update($validated);

        return redirect()
            ->route('taxes.edit', $taxe)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Taxe $taxe): RedirectResponse
    {
        $this->authorize('delete', $taxe);

        $taxe->delete();

        return redirect()
            ->route('taxes.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
