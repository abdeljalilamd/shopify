<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AffiliateProgramResource;
use App\Http\Resources\AffiliateProgramCollection;

class CustomerAffiliateProgramsController extends Controller
{
    public function index(
        Request $request,
        Customer $customer
    ): AffiliateProgramCollection {
        $this->authorize('view', $customer);

        $search = $request->get('search', '');

        $affiliatePrograms = $customer
            ->referralPrograms()
            ->search($search)
            ->latest()
            ->paginate();

        return new AffiliateProgramCollection($affiliatePrograms);
    }

    public function store(
        Request $request,
        Customer $customer
    ): AffiliateProgramResource {
        $this->authorize('create', AffiliateProgram::class);

        $validated = $request->validate([
            'commission' => ['required', 'numeric'],
        ]);

        $affiliateProgram = $customer->referralPrograms()->create($validated);

        return new AffiliateProgramResource($affiliateProgram);
    }
}
