<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerWishlistResource;
use App\Http\Resources\CustomerWishlistCollection;

class ProductCustomerWishlistsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): CustomerWishlistCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $customerWishlists = $product
            ->customerWishlists()
            ->search($search)
            ->latest()
            ->paginate();

        return new CustomerWishlistCollection($customerWishlists);
    }

    public function store(
        Request $request,
        Product $product
    ): CustomerWishlistResource {
        $this->authorize('create', CustomerWishlist::class);

        $validated = $request->validate([]);

        $customerWishlist = $product->customerWishlists()->create($validated);

        return new CustomerWishlistResource($customerWishlist);
    }
}
