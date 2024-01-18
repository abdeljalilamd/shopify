<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\EmailTemplate;
use App\Http\Controllers\Controller;
use App\Http\Resources\EmailTemplateResource;
use App\Http\Resources\EmailTemplateCollection;
use App\Http\Requests\EmailTemplateStoreRequest;
use App\Http\Requests\EmailTemplateUpdateRequest;

class EmailTemplateController extends Controller
{
    public function index(Request $request): EmailTemplateCollection
    {
        $this->authorize('view-any', EmailTemplate::class);

        $search = $request->get('search', '');

        $emailTemplates = EmailTemplate::search($search)
            ->latest()
            ->paginate();

        return new EmailTemplateCollection($emailTemplates);
    }

    public function store(
        EmailTemplateStoreRequest $request
    ): EmailTemplateResource {
        $this->authorize('create', EmailTemplate::class);

        $validated = $request->validated();

        $emailTemplate = EmailTemplate::create($validated);

        return new EmailTemplateResource($emailTemplate);
    }

    public function show(
        Request $request,
        EmailTemplate $emailTemplate
    ): EmailTemplateResource {
        $this->authorize('view', $emailTemplate);

        return new EmailTemplateResource($emailTemplate);
    }

    public function update(
        EmailTemplateUpdateRequest $request,
        EmailTemplate $emailTemplate
    ): EmailTemplateResource {
        $this->authorize('update', $emailTemplate);

        $validated = $request->validated();

        $emailTemplate->update($validated);

        return new EmailTemplateResource($emailTemplate);
    }

    public function destroy(
        Request $request,
        EmailTemplate $emailTemplate
    ): Response {
        $this->authorize('delete', $emailTemplate);

        $emailTemplate->delete();

        return response()->noContent();
    }
}
