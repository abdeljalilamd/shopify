<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $products = Product::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.products.index', compact('products', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);

        $categories = Categorie::pluck('title', 'id');

        return view('app.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $product = Product::create($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Product $product): View
    {
        $this->authorize('view', $product);

        return view('app.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Product $product): View
    {
        $this->authorize('update', $product);

        $categories = Categorie::pluck('title', 'id');

        return view('app.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        ProductUpdateRequest $request,
        Product $product
    ): RedirectResponse {
        $this->authorize('update', $product);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete($product->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Product $product
    ): RedirectResponse {
        $this->authorize('delete', $product);

        if ($product->image) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
