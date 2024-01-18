<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariantResource;
use App\Http\Resources\ProductVariantCollection;

class ProductProductVariantsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): ProductVariantCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productVariants = $product
            ->productVariants()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductVariantCollection($productVariants);
    }

    public function store(
        Request $request,
        Product $product
    ): ProductVariantResource {
        $this->authorize('create', ProductVariant::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $productVariant = $product->productVariants()->create($validated);

        return new ProductVariantResource($productVariant);
    }
}
