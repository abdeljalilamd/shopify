<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\SeoSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SeoSettingStoreRequest;
use App\Http\Requests\SeoSettingUpdateRequest;

class SeoSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SeoSetting::class);

        $search = $request->get('search', '');

        $seoSettings = SeoSetting::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.seo_settings.index', compact('seoSettings', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SeoSetting::class);

        return view('app.seo_settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SeoSettingStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', SeoSetting::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $seoSetting = SeoSetting::create($validated);

        return redirect()
            ->route('seo-settings.edit', $seoSetting)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, SeoSetting $seoSetting): View
    {
        $this->authorize('view', $seoSetting);

        return view('app.seo_settings.show', compact('seoSetting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, SeoSetting $seoSetting): View
    {
        $this->authorize('update', $seoSetting);

        return view('app.seo_settings.edit', compact('seoSetting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SeoSettingUpdateRequest $request,
        SeoSetting $seoSetting
    ): RedirectResponse {
        $this->authorize('update', $seoSetting);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($seoSetting->image) {
                Storage::delete($seoSetting->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $seoSetting->update($validated);

        return redirect()
            ->route('seo-settings.edit', $seoSetting)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SeoSetting $seoSetting
    ): RedirectResponse {
        $this->authorize('delete', $seoSetting);

        if ($seoSetting->image) {
            Storage::delete($seoSetting->image);
        }

        $seoSetting->delete();

        return redirect()
            ->route('seo-settings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
