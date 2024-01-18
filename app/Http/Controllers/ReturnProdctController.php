<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use App\Models\ReturnProdct;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ReturnProdctStoreRequest;
use App\Http\Requests\ReturnProdctUpdateRequest;

class ReturnProdctController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ReturnProdct::class);

        $search = $request->get('search', '');

        $returnProdcts = ReturnProdct::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.return_prodcts.index',
            compact('returnProdcts', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ReturnProdct::class);

        $orders = Order::pluck('status', 'id');

        return view('app.return_prodcts.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReturnProdctStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', ReturnProdct::class);

        $validated = $request->validated();

        $returnProdct = ReturnProdct::create($validated);

        return redirect()
            ->route('return-prodcts.edit', $returnProdct)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ReturnProdct $returnProdct): View
    {
        $this->authorize('view', $returnProdct);

        return view('app.return_prodcts.show', compact('returnProdct'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, ReturnProdct $returnProdct): View
    {
        $this->authorize('update', $returnProdct);

        $orders = Order::pluck('status', 'id');

        return view(
            'app.return_prodcts.edit',
            compact('returnProdct', 'orders')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ReturnProdctUpdateRequest $request,
        ReturnProdct $returnProdct
    ): RedirectResponse {
        $this->authorize('update', $returnProdct);

        $validated = $request->validated();

        $returnProdct->update($validated);

        return redirect()
            ->route('return-prodcts.edit', $returnProdct)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ReturnProdct $returnProdct
    ): RedirectResponse {
        $this->authorize('delete', $returnProdct);

        $returnProdct->delete();

        return redirect()
            ->route('return-prodcts.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
