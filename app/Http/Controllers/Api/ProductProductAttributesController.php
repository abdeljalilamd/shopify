<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductAttributeResource;
use App\Http\Resources\ProductAttributeCollection;

class ProductProductAttributesController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): ProductAttributeCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productAttributes = $product
            ->productAttributes()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductAttributeCollection($productAttributes);
    }

    public function store(
        Request $request,
        Product $product
    ): ProductAttributeResource {
        $this->authorize('create', ProductAttribute::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'value' => ['required', 'max:255', 'string'],
        ]);

        $productAttribute = $product->productAttributes()->create($validated);

        return new ProductAttributeResource($productAttribute);
    }
}
