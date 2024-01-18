<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentMethodResource;
use App\Http\Resources\PaymentMethodCollection;
use App\Http\Requests\PaymentMethodStoreRequest;
use App\Http\Requests\PaymentMethodUpdateRequest;

class PaymentMethodController extends Controller
{
    public function index(Request $request): PaymentMethodCollection
    {
        $this->authorize('view-any', PaymentMethod::class);

        $search = $request->get('search', '');

        $paymentMethods = PaymentMethod::search($search)
            ->latest()
            ->paginate();

        return new PaymentMethodCollection($paymentMethods);
    }

    public function store(
        PaymentMethodStoreRequest $request
    ): PaymentMethodResource {
        $this->authorize('create', PaymentMethod::class);

        $validated = $request->validated();

        $paymentMethod = PaymentMethod::create($validated);

        return new PaymentMethodResource($paymentMethod);
    }

    public function show(
        Request $request,
        PaymentMethod $paymentMethod
    ): PaymentMethodResource {
        $this->authorize('view', $paymentMethod);

        return new PaymentMethodResource($paymentMethod);
    }

    public function update(
        PaymentMethodUpdateRequest $request,
        PaymentMethod $paymentMethod
    ): PaymentMethodResource {
        $this->authorize('update', $paymentMethod);

        $validated = $request->validated();

        $paymentMethod->update($validated);

        return new PaymentMethodResource($paymentMethod);
    }

    public function destroy(
        Request $request,
        PaymentMethod $paymentMethod
    ): Response {
        $this->authorize('delete', $paymentMethod);

        $paymentMethod->delete();

        return response()->noContent();
    }
}
