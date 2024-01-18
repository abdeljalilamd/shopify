<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ProductReviewCollection;

class CustomerProductReviewsController extends Controller
{
    public function index(
        Request $request,
        Customer $customer
    ): ProductReviewCollection {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $productReviews = $customer
            ->productReviews()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductReviewCollection($productReviews);
    }

    public function store(
        Request $request,
        Customer $customer
    ): ProductReviewResource {
        $this->authorize('create', ProductReview::class);

        $validated = $request->validate([
            'rating' => ['required', 'numeric'],
            'text' => ['required', 'max:255', 'string'],
        ]);

        $productReview = $customer->productReviews()->create($validated);

        return new ProductReviewResource($productReview);
    }
}
