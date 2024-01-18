<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerWishlistResource;
use App\Http\Resources\CustomerWishlistCollection;

class CustomerCustomerWishlistsController extends Controller
{
    public function index(
        Request $request,
        Customer $customer
    ): CustomerWishlistCollection {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $customerWishlists = $customer
            ->customerWishlists()
            ->search($search)
            ->latest()
            ->paginate();

        return new CustomerWishlistCollection($customerWishlists);
    }

    public function store(
        Request $request,
        Customer $customer
    ): CustomerWishlistResource {
        $this->authorize('create', CustomerWishlist::class);

        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $customerWishlist = $customer->customerWishlists()->create($validated);

        return new CustomerWishlistResource($customerWishlist);
    }
}
