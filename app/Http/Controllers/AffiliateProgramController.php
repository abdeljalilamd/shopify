<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\AffiliateProgram;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\AffiliateProgramStoreRequest;
use App\Http\Requests\AffiliateProgramUpdateRequest;

class AffiliateProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', AffiliateProgram::class);

        $search = $request->get('search', '');

        $affiliatePrograms = AffiliateProgram::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.affiliate_programs.index',
            compact('affiliatePrograms', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', AffiliateProgram::class);

        $customers = Customer::pluck('address', 'id');

        return view(
            'app.affiliate_programs.create',
            compact('customers', 'customers')
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        AffiliateProgramStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', AffiliateProgram::class);

        $validated = $request->validated();

        $affiliateProgram = AffiliateProgram::create($validated);

        return redirect()
            ->route('affiliate-programs.edit', $affiliateProgram)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): View {
        $this->authorize('view', $affiliateProgram);

        return view('app.affiliate_programs.show', compact('affiliateProgram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): View {
        $this->authorize('update', $affiliateProgram);

        $customers = Customer::pluck('address', 'id');

        return view(
            'app.affiliate_programs.edit',
            compact('affiliateProgram', 'customers', 'customers')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        AffiliateProgramUpdateRequest $request,
        AffiliateProgram $affiliateProgram
    ): RedirectResponse {
        $this->authorize('update', $affiliateProgram);

        $validated = $request->validated();

        $affiliateProgram->update($validated);

        return redirect()
            ->route('affiliate-programs.edit', $affiliateProgram)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        AffiliateProgram $affiliateProgram
    ): RedirectResponse {
        $this->authorize('delete', $affiliateProgram);

        $affiliateProgram->delete();

        return redirect()
            ->route('affiliate-programs.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
