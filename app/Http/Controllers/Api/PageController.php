<?php

namespace App\Http\Controllers\Api;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\PageResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\PageCollection;
use App\Http\Requests\PageStoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PageUpdateRequest;

class PageController extends Controller
{
    public function index(Request $request): PageCollection
    {
        $this->authorize('view-any', Page::class);

        $search = $request->get('search', '');

        $pages = Page::search($search)
            ->latest()
            ->paginate();

        return new PageCollection($pages);
    }

    public function store(PageStoreRequest $request): PageResource
    {
        $this->authorize('create', Page::class);

        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $page = Page::create($validated);

        return new PageResource($page);
    }

    public function show(Request $request, Page $page): PageResource
    {
        $this->authorize('view', $page);

        return new PageResource($page);
    }

    public function update(PageUpdateRequest $request, Page $page): PageResource
    {
        $this->authorize('update', $page);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            if ($page->image) {
                Storage::delete($page->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $page->update($validated);

        return new PageResource($page);
    }

    public function destroy(Request $request, Page $page): Response
    {
        $this->authorize('delete', $page);

        if ($page->image) {
            Storage::delete($page->image);
        }

        $page->delete();

        return response()->noContent();
    }
}
