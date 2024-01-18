<?php

namespace App\Http\Controllers\Api;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategorieResource;
use App\Http\Resources\CategorieCollection;
use App\Http\Requests\CategorieStoreRequest;
use App\Http\Requests\CategorieUpdateRequest;

class CategorieController extends Controller
{
    public function index(Request $request): CategorieCollection
    {
        $this->authorize('view-any', Categorie::class);

        $search = $request->get('search', '');

        $categories = Categorie::search($search)
            ->latest()
            ->paginate();

        return new CategorieCollection($categories);
    }

    public function store(CategorieStoreRequest $request): CategorieResource
    {
        $this->authorize('create', Categorie::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $categorie = Categorie::create($validated);

        return new CategorieResource($categorie);
    }

    public function show(
        Request $request,
        Categorie $categorie
    ): CategorieResource {
        $this->authorize('view', $categorie);

        return new CategorieResource($categorie);
    }

    public function update(
        CategorieUpdateRequest $request,
        Categorie $categorie
    ): CategorieResource {
        $this->authorize('update', $categorie);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($categorie->image) {
                Storage::delete($categorie->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $categorie->update($validated);

        return new CategorieResource($categorie);
    }

    public function destroy(Request $request, Categorie $categorie): Response
    {
        $this->authorize('delete', $categorie);

        if ($categorie->image) {
            Storage::delete($categorie->image);
        }

        $categorie->delete();

        return response()->noContent();
    }
}
