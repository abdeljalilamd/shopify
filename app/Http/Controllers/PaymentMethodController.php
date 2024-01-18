<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', PaymentMethod::class);

        $search = $request->get('search', '');

        $paymentMethods = PaymentMethod::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.payment_methods.index',
            compact('paymentMethods', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', PaymentMethod::class);

        return view('app.payment_methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PaymentMethodStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', PaymentMethod::class);

        $validated = $request->validated();

        $paymentMethod = PaymentMethod::create($validated);

        return redirect()
            ->route('payment-methods.edit', $paymentMethod)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, PaymentMethod $paymentMethod): View
    {
        $this->authorize('view', $paymentMethod);

        return view('app.payment_methods.show', compact('paymentMethod'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, PaymentMethod $paymentMethod): View
    {
        $this->authorize('update', $paymentMethod);

        return view('app.payment_methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        PaymentMethodUpdateRequest $request,
        PaymentMethod $paymentMethod
    ): RedirectResponse {
        $this->authorize('update', $paymentMethod);

        $validated = $request->validated();

        $paymentMethod->update($validated);

        return redirect()
            ->route('payment-methods.edit', $paymentMethod)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        PaymentMethod $paymentMethod
    ): RedirectResponse {
        $this->authorize('delete', $paymentMethod);

        $paymentMethod->delete();

        return redirect()
            ->route('payment-methods.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
