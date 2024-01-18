<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\UserActivitie;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserActivitieResource;
use App\Http\Resources\UserActivitieCollection;
use App\Http\Requests\UserActivitieStoreRequest;
use App\Http\Requests\UserActivitieUpdateRequest;

class UserActivitieController extends Controller
{
    public function index(Request $request): UserActivitieCollection
    {
        $this->authorize('view-any', UserActivitie::class);

        $search = $request->get('search', '');

        $userActivities = UserActivitie::search($search)
            ->latest()
            ->paginate();

        return new UserActivitieCollection($userActivities);
    }

    public function store(
        UserActivitieStoreRequest $request
    ): UserActivitieResource {
        $this->authorize('create', UserActivitie::class);

        $validated = $request->validated();

        $userActivitie = UserActivitie::create($validated);

        return new UserActivitieResource($userActivitie);
    }

    public function show(
        Request $request,
        UserActivitie $userActivitie
    ): UserActivitieResource {
        $this->authorize('view', $userActivitie);

        return new UserActivitieResource($userActivitie);
    }

    public function update(
        UserActivitieUpdateRequest $request,
        UserActivitie $userActivitie
    ): UserActivitieResource {
        $this->authorize('update', $userActivitie);

        $validated = $request->validated();

        $userActivitie->update($validated);

        return new UserActivitieResource($userActivitie);
    }

    public function destroy(
        Request $request,
        UserActivitie $userActivitie
    ): Response {
        $this->authorize('delete', $userActivitie);

        $userActivitie->delete();

        return response()->noContent();
    }
}
