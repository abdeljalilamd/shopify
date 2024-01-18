<?php

namespace App\Http\Controllers\Api;

use App\Models\Taxe;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TaxeResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaxeCollection;
use App\Http\Requests\TaxeStoreRequest;
use App\Http\Requests\TaxeUpdateRequest;

class TaxeController extends Controller
{
    public function index(Request $request): TaxeCollection
    {
        $this->authorize('view-any', Taxe::class);

        $search = $request->get('search', '');

        $taxes = Taxe::search($search)
            ->latest()
            ->paginate();

        return new TaxeCollection($taxes);
    }

    public function store(TaxeStoreRequest $request): TaxeResource
    {
        $this->authorize('create', Taxe::class);

        $validated = $request->validated();

        $taxe = Taxe::create($validated);

        return new TaxeResource($taxe);
    }

    public function show(Request $request, Taxe $taxe): TaxeResource
    {
        $this->authorize('view', $taxe);

        return new TaxeResource($taxe);
    }

    public function update(TaxeUpdateRequest $request, Taxe $taxe): TaxeResource
    {
        $this->authorize('update', $taxe);

        $validated = $request->validated();

        $taxe->update($validated);

        return new TaxeResource($taxe);
    }

    public function destroy(Request $request, Taxe $taxe): Response
    {
        $this->authorize('delete', $taxe);

        $taxe->delete();

        return response()->noContent();
    }
}
