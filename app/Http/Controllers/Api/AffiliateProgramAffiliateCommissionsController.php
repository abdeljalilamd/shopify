<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\AffiliateProgram;
use App\Http\Controllers\Controller;
use App\Http\Resources\AffiliateCommissionResource;
use App\Http\Resources\AffiliateCommissionCollection;

class AffiliateProgramAffiliateCommissionsController extends Controller
{
    public function index(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): AffiliateCommissionCollection {
        $this->authorize('view', $affiliateProgram);

        $search = $request->get('search', '');

        $affiliateCommissions = $affiliateProgram
            ->affiliateCommissions()
            ->search($search)
            ->latest()
            ->paginate();

        return new AffiliateCommissionCollection($affiliateCommissions);
    }

    public function store(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): AffiliateCommissionResource {
        $this->authorize('create', AffiliateCommission::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $affiliateCommission = $affiliateProgram
            ->affiliateCommissions()
            ->create($validated);

        return new AffiliateCommissionResource($affiliateCommission);
    }
}
