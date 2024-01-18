<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserActivitieResource;
use App\Http\Resources\UserActivitieCollection;

class UserUserActivitiesController extends Controller
{
    public function index(Request $request, User $user): UserActivitieCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $userActivities = $user
            ->userActivities()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserActivitieCollection($userActivities);
    }

    public function store(Request $request, User $user): UserActivitieResource
    {
        $this->authorize('create', UserActivitie::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
        ]);

        $userActivitie = $user->userActivities()->create($validated);

        return new UserActivitieResource($userActivitie);
    }
}
