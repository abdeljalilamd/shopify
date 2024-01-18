<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Http\Resources\NotificationCollection;

class UserNotificationsController extends Controller
{
    public function index(Request $request, User $user): NotificationCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $notifications = $user
            ->notifications()
            ->search($search)
            ->latest()
            ->paginate();

        return new NotificationCollection($notifications);
    }

    public function store(Request $request, User $user): NotificationResource
    {
        $this->authorize('create', Notification::class);

        $validated = $request->validate([
            'content' => ['required', 'max:255', 'string'],
        ]);

        $notification = $user->notifications()->create($validated);

        return new NotificationResource($notification);
    }
}
