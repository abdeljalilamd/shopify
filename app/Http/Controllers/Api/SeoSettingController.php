<?php

namespace App\Http\Controllers\Api;

use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\SeoSettingResource;
use App\Http\Resources\SeoSettingCollection;
use App\Http\Requests\SeoSettingStoreRequest;
use App\Http\Requests\SeoSettingUpdateRequest;

class SeoSettingController extends Controller
{
    public function index(Request $request): SeoSettingCollection
    {
        $this->authorize('view-any', SeoSetting::class);

        $search = $request->get('search', '');

        $seoSettings = SeoSetting::search($search)
            ->latest()
            ->paginate();

        return new SeoSettingCollection($seoSettings);
    }

    public function store(SeoSettingStoreRequest $request): SeoSettingResource
    {
        $this->authorize('create', SeoSetting::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $seoSetting = SeoSetting::create($validated);

        return new SeoSettingResource($seoSetting);
    }

    public function show(
        Request $request,
        SeoSetting $seoSetting
    ): SeoSettingResource {
        $this->authorize('view', $seoSetting);

        return new SeoSettingResource($seoSetting);
    }

    public function update(
        SeoSettingUpdateRequest $request,
        SeoSetting $seoSetting
    ): SeoSettingResource {
        $this->authorize('update', $seoSetting);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($seoSetting->image) {
                Storage::delete($seoSetting->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $seoSetting->update($validated);

        return new SeoSettingResource($seoSetting);
    }

    public function destroy(Request $request, SeoSetting $seoSetting): Response
    {
        $this->authorize('delete', $seoSetting);

        if ($seoSetting->image) {
            Storage::delete($seoSetting->image);
        }

        $seoSetting->delete();

        return response()->noContent();
    }
}
