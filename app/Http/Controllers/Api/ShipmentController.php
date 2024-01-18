<?php

namespace App\Http\Controllers\Api;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Http\Resources\ShipmentCollection;
use App\Http\Requests\ShipmentStoreRequest;
use App\Http\Requests\ShipmentUpdateRequest;

class ShipmentController extends Controller
{
    public function index(Request $request): ShipmentCollection
    {
        $this->authorize('view-any', Shipment::class);

        $search = $request->get('search', '');

        $shipments = Shipment::search($search)
            ->latest()
            ->paginate();

        return new ShipmentCollection($shipments);
    }

    public function store(ShipmentStoreRequest $request): ShipmentResource
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validated();

        $shipment = Shipment::create($validated);

        return new ShipmentResource($shipment);
    }

    public function show(Request $request, Shipment $shipment): ShipmentResource
    {
        $this->authorize('view', $shipment);

        return new ShipmentResource($shipment);
    }

    public function update(
        ShipmentUpdateRequest $request,
        Shipment $shipment
    ): ShipmentResource {
        $this->authorize('update', $shipment);

        $validated = $request->validated();

        $shipment->update($validated);

        return new ShipmentResource($shipment);
    }

    public function destroy(Request $request, Shipment $shipment): Response
    {
        $this->authorize('delete', $shipment);

        $shipment->delete();

        return response()->noContent();
    }
}
