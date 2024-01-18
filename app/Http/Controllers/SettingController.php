<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SettingStoreRequest;
use App\Http\Requests\SettingUpdateRequest;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Setting::class);

        $search = $request->get('search', '');

        $settings = Setting::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.settings.index', compact('settings', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Setting::class);

        return view('app.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SettingStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Setting::class);

        $validated = $request->validated();

        $setting = Setting::create($validated);

        return redirect()
            ->route('settings.edit', $setting)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Setting $setting): View
    {
        $this->authorize('view', $setting);

        return view('app.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Setting $setting): View
    {
        $this->authorize('update', $setting);

        return view('app.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SettingUpdateRequest $request,
        Setting $setting
    ): RedirectResponse {
        $this->authorize('update', $setting);

        $validated = $request->validated();

        $setting->update($validated);

        return redirect()
            ->route('settings.edit', $setting)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Setting $setting
    ): RedirectResponse {
        $this->authorize('delete', $setting);

        $setting->delete();

        return redirect()
            ->route('settings.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
