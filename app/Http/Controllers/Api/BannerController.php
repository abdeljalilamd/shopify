<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\BannerResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\BannerCollection;
use App\Http\Requests\BannerStoreRequest;
use App\Http\Requests\BannerUpdateRequest;

class BannerController extends Controller
{
    public function index(Request $request): BannerCollection
    {
        $this->authorize('view-any', Banner::class);

        $search = $request->get('search', '');

        $banners = Banner::search($search)
            ->latest()
            ->paginate();

        return new BannerCollection($banners);
    }

    public function store(BannerStoreRequest $request): BannerResource
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

        return new BannerResource($banner);
    }

    public function show(Request $request, Banner $banner): BannerResource
    {
        $this->authorize('view', $banner);

        return new BannerResource($banner);
    }

    public function update(
        BannerUpdateRequest $request,
        Banner $banner
    ): BannerResource {
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

        return new BannerResource($banner);
    }

    public function destroy(Request $request, Banner $banner): Response
    {
        $this->authorize('delete', $banner);

        if ($banner->image) {
            Storage::delete($banner->image);
        }

        if ($banner->image_url) {
            Storage::delete($banner->image_url);
        }

        $banner->delete();

        return response()->noContent();
    }
}
