<?php

namespace App\Http\Controllers\Api;

use App\Models\ReturnProdct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReturnProdctResource;
use App\Http\Resources\ReturnProdctCollection;
use App\Http\Requests\ReturnProdctStoreRequest;
use App\Http\Requests\ReturnProdctUpdateRequest;

class ReturnProdctController extends Controller
{
    public function index(Request $request): ReturnProdctCollection
    {
        $this->authorize('view-any', ReturnProdct::class);

        $search = $request->get('search', '');

        $returnProdcts = ReturnProdct::search($search)
            ->latest()
            ->paginate();

        return new ReturnProdctCollection($returnProdcts);
    }

    public function store(
        ReturnProdctStoreRequest $request
    ): ReturnProdctResource {
        $this->authorize('create', ReturnProdct::class);

        $validated = $request->validated();

        $returnProdct = ReturnProdct::create($validated);

        return new ReturnProdctResource($returnProdct);
    }

    public function show(
        Request $request,
        ReturnProdct $returnProdct
    ): ReturnProdctResource {
        $this->authorize('view', $returnProdct);

        return new ReturnProdctResource($returnProdct);
    }

    public function update(
        ReturnProdctUpdateRequest $request,
        ReturnProdct $returnProdct
    ): ReturnProdctResource {
        $this->authorize('update', $returnProdct);

        $validated = $request->validated();

        $returnProdct->update($validated);

        return new ReturnProdctResource($returnProdct);
    }

    public function destroy(
        Request $request,
        ReturnProdct $returnProdct
    ): Response {
        $this->authorize('delete', $returnProdct);

        $returnProdct->delete();

        return response()->noContent();
    }
}
