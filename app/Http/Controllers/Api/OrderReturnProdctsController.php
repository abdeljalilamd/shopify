<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReturnProdctResource;
use App\Http\Resources\ReturnProdctCollection;

class OrderReturnProdctsController extends Controller
{
    public function index(
        Request $request,
        Order $order
    ): ReturnProdctCollection {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $returnProdcts = $order
            ->returnProdcts()
            ->search($search)
            ->latest()
            ->paginate();

        return new ReturnProdctCollection($returnProdcts);
    }

    public function store(Request $request, Order $order): ReturnProdctResource
    {
        $this->authorize('create', ReturnProdct::class);

        $validated = $request->validate([
            'reason' => ['required', 'max:255', 'string'],
        ]);

        $returnProdct = $order->returnProdcts()->create($validated);

        return new ReturnProdctResource($returnProdct);
    }
}
