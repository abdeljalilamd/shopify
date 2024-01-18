<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ExternalIntegration;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExternalIntegrationResource;
use App\Http\Resources\ExternalIntegrationCollection;
use App\Http\Requests\ExternalIntegrationStoreRequest;
use App\Http\Requests\ExternalIntegrationUpdateRequest;

class ExternalIntegrationController extends Controller
{
    public function index(Request $request): ExternalIntegrationCollection
    {
        $this->authorize('view-any', ExternalIntegration::class);

        $search = $request->get('search', '');

        $externalIntegrations = ExternalIntegration::search($search)
            ->latest()
            ->paginate();

        return new ExternalIntegrationCollection($externalIntegrations);
    }

    public function store(
        ExternalIntegrationStoreRequest $request
    ): ExternalIntegrationResource {
        $this->authorize('create', ExternalIntegration::class);

        $validated = $request->validated();

        $externalIntegration = ExternalIntegration::create($validated);

        return new ExternalIntegrationResource($externalIntegration);
    }

    public function show(
        Request $request,
        ExternalIntegration $externalIntegration
    ): ExternalIntegrationResource {
        $this->authorize('view', $externalIntegration);

        return new ExternalIntegrationResource($externalIntegration);
    }

    public function update(
        ExternalIntegrationUpdateRequest $request,
        ExternalIntegration $externalIntegration
    ): ExternalIntegrationResource {
        $this->authorize('update', $externalIntegration);

        $validated = $request->validated();

        $externalIntegration->update($validated);

        return new ExternalIntegrationResource($externalIntegration);
    }

    public function destroy(
        Request $request,
        ExternalIntegration $externalIntegration
    ): Response {
        $this->authorize('delete', $externalIntegration);

        $externalIntegration->delete();

        return response()->noContent();
    }
}
