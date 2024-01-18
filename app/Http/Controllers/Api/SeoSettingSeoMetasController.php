<?php

namespace App\Http\Controllers\Api;

use App\Models\SeoSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SeoMetaResource;
use App\Http\Resources\SeoMetaCollection;

class SeoSettingSeoMetasController extends Controller
{
    public function index(
        Request $request,
        SeoSetting $seoSetting
    ): SeoMetaCollection {
        $this->authorize('view', $seoSetting);

        $search = $request->get('search', '');

        $seoMetas = $seoSetting
            ->seoMetas()
            ->search($search)
            ->latest()
            ->paginate();

        return new SeoMetaCollection($seoMetas);
    }

    public function store(
        Request $request,
        SeoSetting $seoSetting
    ): SeoMetaResource {
        $this->authorize('create', SeoMeta::class);

        $validated = $request->validate([
            'type' => ['required', 'max:255', 'string'],
            'key' => ['required', 'max:255', 'string'],
        ]);

        $seoMeta = $seoSetting->seoMetas()->create($validated);

        return new SeoMetaResource($seoMeta);
    }
}
