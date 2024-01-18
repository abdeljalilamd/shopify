<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\ExternalIntegration;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\ExternalIntegrationStoreRequest;
use App\Http\Requests\ExternalIntegrationUpdateRequest;

class ExternalIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', ExternalIntegration::class);

        $search = $request->get('search', '');

        $externalIntegrations = ExternalIntegration::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.external_integrations.index',
            compact('externalIntegrations', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', ExternalIntegration::class);

        return view('app.external_integrations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ExternalIntegrationStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', ExternalIntegration::class);

        $validated = $request->validated();

        $externalIntegration = ExternalIntegration::create($validated);

        return redirect()
            ->route('external-integrations.edit', $externalIntegration)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        ExternalIntegration $externalIntegration
    ): View {
        $this->authorize('view', $externalIntegration);

        return view(
            'app.external_integrations.show',
            compact('externalIntegration')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        ExternalIntegration $externalIntegration
    ): View {
        $this->authorize('update', $externalIntegration);

        return view(
            'app.external_integrations.edit',
            compact('externalIntegration')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ExternalIntegrationUpdateRequest $request,
        ExternalIntegration $externalIntegration
    ): RedirectResponse {
        $this->authorize('update', $externalIntegration);

        $validated = $request->validated();

        $externalIntegration->update($validated);

        return redirect()
            ->route('external-integrations.edit', $externalIntegration)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        ExternalIntegration $externalIntegration
    ): RedirectResponse {
        $this->authorize('delete', $externalIntegration);

        $externalIntegration->delete();

        return redirect()
            ->route('external-integrations.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
