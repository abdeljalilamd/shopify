<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductTagResource;
use App\Http\Resources\ProductTagCollection;

class ProductProductTagsController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): ProductTagCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productTags = $product
            ->productTags()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductTagCollection($productTags);
    }

    public function store(
        Request $request,
        Product $product
    ): ProductTagResource {
        $this->authorize('create', ProductTag::class);

        $validated = $request->validate([
            'tag' => ['required', 'max:255', 'string'],
        ]);

        $productTag = $product->productTags()->create($validated);

        return new ProductTagResource($productTag);
    }
}
