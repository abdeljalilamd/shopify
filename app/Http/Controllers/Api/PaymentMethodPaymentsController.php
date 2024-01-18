<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;

class PaymentMethodPaymentsController extends Controller
{
    public function index(
        Request $request,
        PaymentMethod $paymentMethod
    ): PaymentCollection {
        $this->authorize('view', $paymentMethod);

        $search = $request->get('search', '');

        $payments = $paymentMethod
            ->payments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentCollection($payments);
    }

    public function store(
        Request $request,
        PaymentMethod $paymentMethod
    ): PaymentResource {
        $this->authorize('create', Payment::class);

        $validated = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'amount' => ['required', 'numeric'],
        ]);

        $payment = $paymentMethod->payments()->create($validated);

        return new PaymentResource($payment);
    }
}
