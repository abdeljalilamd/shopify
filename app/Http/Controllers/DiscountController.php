<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\DiscountStoreRequest;
use App\Http\Requests\DiscountUpdateRequest;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Discount::class);

        $search = $request->get('search', '');

        $discounts = Discount::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.discounts.index', compact('discounts', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Discount::class);

        return view('app.discounts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Discount::class);

        $validated = $request->validated();

        $discount = Discount::create($validated);

        return redirect()
            ->route('discounts.edit', $discount)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Discount $discount): View
    {
        $this->authorize('view', $discount);

        return view('app.discounts.show', compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Discount $discount): View
    {
        $this->authorize('update', $discount);

        return view('app.discounts.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DiscountUpdateRequest $request,
        Discount $discount
    ): RedirectResponse {
        $this->authorize('update', $discount);

        $validated = $request->validated();

        $discount->update($validated);

        return redirect()
            ->route('discounts.edit', $discount)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Discount $discount
    ): RedirectResponse {
        $this->authorize('delete', $discount);

        $discount->delete();

        return redirect()
            ->route('discounts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
