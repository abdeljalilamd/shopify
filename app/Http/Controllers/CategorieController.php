<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategorieStoreRequest;
use App\Http\Requests\CategorieUpdateRequest;

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Categorie::class);

        $search = $request->get('search', '');

        $categories = Categorie::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Categorie::class);

        return view('app.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorieStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Categorie::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $categorie = Categorie::create($validated);

        return redirect()
            ->route('categories.edit', $categorie)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Categorie $categorie): View
    {
        $this->authorize('view', $categorie);

        return view('app.categories.show', compact('categorie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Categorie $categorie): View
    {
        $this->authorize('update', $categorie);

        return view('app.categories.edit', compact('categorie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        CategorieUpdateRequest $request,
        Categorie $categorie
    ): RedirectResponse {
        $this->authorize('update', $categorie);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($categorie->image) {
                Storage::delete($categorie->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $categorie->update($validated);

        return redirect()
            ->route('categories.edit', $categorie)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Categorie $categorie
    ): RedirectResponse {
        $this->authorize('delete', $categorie);

        if ($categorie->image) {
            Storage::delete($categorie->image);
        }

        $categorie->delete();

        return redirect()
            ->route('categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
