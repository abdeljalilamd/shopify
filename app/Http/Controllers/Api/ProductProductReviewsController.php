<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductReviewResource;
use App\Http\Resources\ProductReviewCollection;

class ProductProductReviewsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): ProductReviewCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productReviews = $product
            ->productReviews()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductReviewCollection($productReviews);
    }

    public function store(
        Request $request,
        Product $product
    ): ProductReviewResource {
        $this->authorize('create', ProductReview::class);

        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'rating' => ['required', 'numeric'],
            'text' => ['required', 'max:255', 'string'],
        ]);

        $productReview = $product->productReviews()->create($validated);

        return new ProductReviewResource($productReview);
    }
}
