<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SocialMediaLinkResource;
use App\Http\Resources\SocialMediaLinkCollection;

class SettingSocialMediaLinksController extends Controller
{
    public function index(
        Request $request,
        Setting $setting
    ): SocialMediaLinkCollection {
        $this->authorize('view', $setting);

        $search = $request->get('search', '');

        $socialMediaLinks = $setting
            ->socialMediaLinks()
            ->search($search)
            ->latest()
            ->paginate();

        return new SocialMediaLinkCollection($socialMediaLinks);
    }

    public function store(
        Request $request,
        Setting $setting
    ): SocialMediaLinkResource {
        $this->authorize('create', SocialMediaLink::class);

        $validated = $request->validate([
            'platform' => ['required', 'max:255', 'string'],
            'url' => ['required', 'url'],
        ]);

        $socialMediaLink = $setting->socialMediaLinks()->create($validated);

        return new SocialMediaLinkResource($socialMediaLink);
    }
}
