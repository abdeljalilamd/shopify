<?php

namespace App\Http\Controllers\Api;

use App\Models\ReturnProdct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\RefundResource;
use App\Http\Resources\RefundCollection;

class ReturnProdctRefundsController extends Controller
{
    public function index(
        Request $request,
        ReturnProdct $returnProdct
    ): RefundCollection {
        $this->authorize('view', $returnProdct);

        $search = $request->get('search', '');

        $refunds = $returnProdct
            ->refunds()
            ->search($search)
            ->latest()
            ->paginate();

        return new RefundCollection($refunds);
    }

    public function store(
        Request $request,
        ReturnProdct $returnProdct
    ): RefundResource {
        $this->authorize('create', Refund::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
        ]);

        $refund = $returnProdct->refunds()->create($validated);

        return new RefundResource($refund);
    }
}
