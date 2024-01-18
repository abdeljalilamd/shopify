<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ShippingMethodStoreRequest;
use App\Http\Requests\ShippingMethodUpdateRequest;

class ShippingMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ShippingMethod::class);

        $search = $request->get('search', '');

        $shippingMethods = ShippingMethod::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.shipping_methods.index',
            compact('shippingMethods', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ShippingMethod::class);

        return view('app.shipping_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingMethodStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ShippingMethod::class);

        $validated = $request->validated();

        $shippingMethod = ShippingMethod::create($validated);

        return redirect()
            ->route('shipping-methods.edit', $shippingMethod)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ShippingMethod $shippingMethod): View
    {
        $this->authorize('view', $shippingMethod);

        return view('app.shipping_methods.show', compact('shippingMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ShippingMethod $shippingMethod): View
    {
        $this->authorize('update', $shippingMethod);

        return view('app.shipping_methods.edit', compact('shippingMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ShippingMethodUpdateRequest $request,
        ShippingMethod $shippingMethod
    ): RedirectResponse {
        $this->authorize('update', $shippingMethod);

        $validated = $request->validated();

        $shippingMethod->update($validated);

        return redirect()
            ->route('shipping-methods.edit', $shippingMethod)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ShippingMethod $shippingMethod
    ): RedirectResponse {
        $this->authorize('delete', $shippingMethod);

        $shippingMethod->delete();

        return redirect()
            ->route('shipping-methods.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
