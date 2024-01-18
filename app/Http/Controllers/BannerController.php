<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Banner::class);

        $search = $request->get('search', '');

        $banners = Banner::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.banners.index', compact('banners', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Banner::class);

        return view('app.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BannerStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Banner::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request
                ->file('image_url')
                ->store('public');
        }

        $banner = Banner::create($validated);

        return redirect()
            ->route('banners.edit', $banner)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Banner $banner): View
    {
        $this->authorize('view', $banner);

        return view('app.banners.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Banner $banner): View
    {
        $this->authorize('update', $banner);

        return view('app.banners.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        BannerUpdateRequest $request,
        Banner $banner
    ): RedirectResponse {
        $this->authorize('update', $banner);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::delete($banner->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        if ($request->hasFile('image_url')) {
            if ($banner->image_url) {
                Storage::delete($banner->image_url);
            }

            $validated['image_url'] = $request
                ->file('image_url')
                ->store('public');
        }

        $banner->update($validated);

        return redirect()
            ->route('banners.edit', $banner)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Banner $banner): RedirectResponse
    {
        $this->authorize('delete', $banner);

        if ($banner->image) {
            Storage::delete($banner->image);
        }

        if ($banner->image_url) {
            Storage::delete($banner->image_url);
        }

        $banner->delete();

        return redirect()
            ->route('banners.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
