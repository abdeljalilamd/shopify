<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\AffiliateProgram;
use App\Http\Controllers\Controller;
use App\Http\Resources\AffiliateProgramResource;
use App\Http\Resources\AffiliateProgramCollection;
use App\Http\Requests\AffiliateProgramStoreRequest;
use App\Http\Requests\AffiliateProgramUpdateRequest;

class AffiliateProgramController extends Controller
{
    public function index(Request $request): AffiliateProgramCollection
    {
        $this->authorize('view-any', AffiliateProgram::class);

        $search = $request->get('search', '');

        $affiliatePrograms = AffiliateProgram::search($search)
            ->latest()
            ->paginate();

        return new AffiliateProgramCollection($affiliatePrograms);
    }

    public function store(
        AffiliateProgramStoreRequest $request
    ): AffiliateProgramResource {
        $this->authorize('create', AffiliateProgram::class);

        $validated = $request->validated();

        $affiliateProgram = AffiliateProgram::create($validated);

        return new AffiliateProgramResource($affiliateProgram);
    }

    public function show(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): AffiliateProgramResource {
        $this->authorize('view', $affiliateProgram);

        return new AffiliateProgramResource($affiliateProgram);
    }

    public function update(
        AffiliateProgramUpdateRequest $request,
        AffiliateProgram $affiliateProgram
    ): AffiliateProgramResource {
        $this->authorize('update', $affiliateProgram);

        $validated = $request->validated();

        $affiliateProgram->update($validated);

        return new AffiliateProgramResource($affiliateProgram);
    }

    public function destroy(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): Response {
        $this->authorize('delete', $affiliateProgram);

        $affiliateProgram->delete();

        return response()->noContent();
    }
}
