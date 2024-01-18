<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartCollection;

class CustomerCartsController extends Controller
{
    public function index(Request $request, Customer $customer): CartCollection
    {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $carts = $customer
            ->carts()
            ->search($search)
            ->latest()
            ->paginate();

        return new CartCollection($carts);
    }

    public function store(Request $request, Customer $customer): CartResource
    {
        $this->authorize('create', Cart::class);

        $validated = $request->validate([]);

        $cart = $customer->carts()->create($validated);

        return new CartResource($cart);
    }
}
