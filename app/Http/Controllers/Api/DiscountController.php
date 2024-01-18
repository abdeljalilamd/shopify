<?php

namespace App\Http\Controllers\Api;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountResource;
use App\Http\Resources\DiscountCollection;
use App\Http\Requests\DiscountStoreRequest;
use App\Http\Requests\DiscountUpdateRequest;

class DiscountController extends Controller
{
    public function index(Request $request): DiscountCollection
    {
        $this->authorize('view-any', Discount::class);

        $search = $request->get('search', '');

        $discounts = Discount::search($search)
            ->latest()
            ->paginate();

        return new DiscountCollection($discounts);
    }

    public function store(DiscountStoreRequest $request): DiscountResource
    {
        $this->authorize('create', Discount::class);

        $validated = $request->validated();

        $discount = Discount::create($validated);

        return new DiscountResource($discount);
    }

    public function show(Request $request, Discount $discount): DiscountResource
    {
        $this->authorize('view', $discount);

        return new DiscountResource($discount);
    }

    public function update(
        DiscountUpdateRequest $request,
        Discount $discount
    ): DiscountResource {
        $this->authorize('update', $discount);

        $validated = $request->validated();

        $discount->update($validated);

        return new DiscountResource($discount);
    }

    public function destroy(Request $request, Discount $discount): Response
    {
        $this->authorize('delete', $discount);

        $discount->delete();

        return response()->noContent();
    }
}
