<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Http\Resources\CartItemCollection;

class CartCartItemsController extends Controller
{
    public function index(Request $request, Cart $cart): CartItemCollection
    {
        $this->authorize('view', $cart);

        $search = $request->get('search', '');

        $cartItems = $cart
            ->cartItems()
            ->search($search)
            ->latest()
            ->paginate();

        return new CartItemCollection($cartItems);
    }

    public function store(Request $request, Cart $cart): CartItemResource
    {
        $this->authorize('create', CartItem::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'numeric'],
        ]);

        $cartItem = $cart->cartItems()->create($validated);

        return new CartItemResource($cartItem);
    }
}
