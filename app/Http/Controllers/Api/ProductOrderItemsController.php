<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderItemCollection;

class ProductOrderItemsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): OrderItemCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $orderItems = $product
            ->orderItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderItemCollection($orderItems);
    }

    public function store(Request $request, Product $product): OrderItemResource
    {
        $this->authorize('create', OrderItem::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
        ]);

        $orderItem = $product->orderItems()->create($validated);

        return new OrderItemResource($orderItem);
    }
}
