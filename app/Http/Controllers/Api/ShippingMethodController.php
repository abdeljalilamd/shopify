<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ShippingMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\ShippingMethodResource;
use App\Http\Resources\ShippingMethodCollection;
use App\Http\Requests\ShippingMethodStoreRequest;
use App\Http\Requests\ShippingMethodUpdateRequest;

class ShippingMethodController extends Controller
{
    public function index(Request $request): ShippingMethodCollection
    {
        $this->authorize('view-any', ShippingMethod::class);

        $search = $request->get('search', '');

        $shippingMethods = ShippingMethod::search($search)
            ->latest()
            ->paginate();

        return new ShippingMethodCollection($shippingMethods);
    }

    public function store(
        ShippingMethodStoreRequest $request
    ): ShippingMethodResource {
        $this->authorize('create', ShippingMethod::class);

        $validated = $request->validated();

        $shippingMethod = ShippingMethod::create($validated);

        return new ShippingMethodResource($shippingMethod);
    }

    public function show(
        Request $request,
        ShippingMethod $shippingMethod
    ): ShippingMethodResource {
        $this->authorize('view', $shippingMethod);

        return new ShippingMethodResource($shippingMethod);
    }

    public function update(
        ShippingMethodUpdateRequest $request,
        ShippingMethod $shippingMethod
    ): ShippingMethodResource {
        $this->authorize('update', $shippingMethod);

        $validated = $request->validated();

        $shippingMethod->update($validated);

        return new ShippingMethodResource($shippingMethod);
    }

    public function destroy(
        Request $request,
        ShippingMethod $shippingMethod
    ): Response {
        $this->authorize('delete', $shippingMethod);

        $shippingMethod->delete();

        return response()->noContent();
    }
}
