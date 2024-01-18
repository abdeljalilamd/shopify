<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductImageResource;
use App\Http\Resources\ProductImageCollection;

class ProductProductImagesController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): ProductImageCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $productImages = $product
            ->productImages()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductImageCollection($productImages);
    }

    public function store(
        Request $request,
        Product $product
    ): ProductImageResource {
        $this->authorize('create', ProductImage::class);

        $validated = $request->validate([
            'image_url' => ['nullable', 'image', 'max:1024'],
            'image' => ['nullable', 'image', 'max:1024'],
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request
                ->file('image_url')
                ->store('public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $productImage = $product->productImages()->create($validated);

        return new ProductImageResource($productImage);
    }
}
