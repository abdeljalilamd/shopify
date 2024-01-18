<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryResource;
use App\Http\Resources\InventoryCollection;

class ProductInventoriesController extends Controller
{
    public function index(
        Request $request,
        Product $product
    ): InventoryCollection {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $inventories = $product
            ->inventories()
            ->search($search)
            ->latest()
            ->paginate();

        return new InventoryCollection($inventories);
    }

    public function store(Request $request, Product $product): InventoryResource
    {
        $this->authorize('create', Inventory::class);

        $validated = $request->validate([
            'quantity' => ['required', 'numeric'],
        ]);

        $inventory = $product->inventories()->create($validated);

        return new InventoryResource($inventory);
    }
}
