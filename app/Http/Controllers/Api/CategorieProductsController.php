<?php

namespace App\Http\Controllers\Api;

use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class CategorieProductsController extends Controller
{
    public function index(
        Request $request,
        Categorie $categorie
    ): ProductCollection {
        $this->authorize('view', $categorie);

        $search = $request->get('search', '');

        $products = $categorie
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    public function store(
        Request $request,
        Categorie $categorie
    ): ProductResource {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'image' => ['nullable', 'image', 'max:1024'],
            'description' => ['nullable', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'content' => ['required', 'max:255', 'string'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = $categorie->products()->create($validated);

        return new ProductResource($product);
    }
}
