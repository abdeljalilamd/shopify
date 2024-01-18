<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ShippingMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Http\Resources\ShipmentCollection;

class ShippingMethodShipmentsController extends Controller
{
    public function index(
        Request $request,
        ShippingMethod $shippingMethod
    ): ShipmentCollection {
        $this->authorize('view', $shippingMethod);

        $search = $request->get('search', '');

        $shipments = $shippingMethod
            ->shipments()
            ->search($search)
            ->latest()
            ->paginate();

        return new ShipmentCollection($shipments);
    }

    public function store(
        Request $request,
        ShippingMethod $shippingMethod
    ): ShipmentResource {
        $this->authorize('create', Shipment::class);

        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'tracking_number' => ['required', 'max:255', 'string'],
        ]);

        $shipment = $shippingMethod->shipments()->create($validated);

        return new ShipmentResource($shipment);
    }
}
