<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\UserActivitie;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UserActivitieStoreRequest;
use App\Http\Requests\UserActivitieUpdateRequest;

class UserActivitieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', UserActivitie::class);

        $search = $request->get('search', '');

        $userActivities = UserActivitie::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.user_activities.index',
            compact('userActivities', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', UserActivitie::class);

        $users = User::pluck('name', 'id');

        return view('app.user_activities.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserActivitieStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', UserActivitie::class);

        $validated = $request->validated();

        $userActivitie = UserActivitie::create($validated);

        return redirect()
            ->route('user-activities.edit', $userActivitie)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, UserActivitie $userActivitie): View
    {
        $this->authorize('view', $userActivitie);

        return view('app.user_activities.show', compact('userActivitie'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, UserActivitie $userActivitie): View
    {
        $this->authorize('update', $userActivitie);

        $users = User::pluck('name', 'id');

        return view(
            'app.user_activities.edit',
            compact('userActivitie', 'users')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UserActivitieUpdateRequest $request,
        UserActivitie $userActivitie
    ): RedirectResponse {
        $this->authorize('update', $userActivitie);

        $validated = $request->validated();

        $userActivitie->update($validated);

        return redirect()
            ->route('user-activities.edit', $userActivitie)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        UserActivitie $userActivitie
    ): RedirectResponse {
        $this->authorize('delete', $userActivitie);

        $userActivitie->delete();

        return redirect()
            ->route('user-activities.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
