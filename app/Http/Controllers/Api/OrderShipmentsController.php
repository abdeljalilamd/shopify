<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Http\Resources\ShipmentCollection;

class OrderShipmentsController extends Controller
{
    public function index(Request $request, Order $order): ShipmentCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $shipments = $order
            ->shipments()
            ->search($search)
            ->latest()
            ->paginate();

        return new ShipmentCollection($shipments);
    }

    public function store(Request $request, Order $order): ShipmentResource
    {
        $this->authorize('create', Shipment::class);

        $validated = $request->validate([
            'tracking_number' => ['required', 'max:255', 'string'],
            'shipping_method_id' => ['required', 'exists:shipping_methods,id'],
        ]);

        $shipment = $order->shipments()->create($validated);

        return new ShipmentResource($shipment);
    }
}
