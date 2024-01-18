<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartItemCollection;

class ProductCartItemsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): CartItemCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $cartItems = $product
            ->cartItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new CartItemCollection($cartItems);
    }

    public function store(Request $request, Product $product): CartItemResource
    {
        $this->authorize('create', CartItem::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
        ]);

        $cartItem = $product->cartItems()->create($validated);

        return new CartItemResource($cartItem);
    }
}
