<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PaymentCollection;

class OrderPaymentsController extends Controller
{
    public function index(Request $request, Order $order): PaymentCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $payments = $order
            ->payments()
            ->search($search)
            ->latest()
            ->paginate();

        return new PaymentCollection($payments);
    }

    public function store(Request $request, Order $order): PaymentResource
    {
        $this->authorize('create', Payment::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ]);

        $payment = $order->payments()->create($validated);

        return new PaymentResource($payment);
    }
}
