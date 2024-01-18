<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\EmailTemplateStoreRequest;
use App\Http\Requests\EmailTemplateUpdateRequest;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', EmailTemplate::class);

        $search = $request->get('search', '');

        $emailTemplates = EmailTemplate::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.email_templates.index',
            compact('emailTemplates', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', EmailTemplate::class);

        return view('app.email_templates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmailTemplateStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', EmailTemplate::class);

        $validated = $request->validated();

        $emailTemplate = EmailTemplate::create($validated);

        return redirect()
            ->route('email-templates.edit', $emailTemplate)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, EmailTemplate $emailTemplate): View
    {
        $this->authorize('view', $emailTemplate);

        return view('app.email_templates.show', compact('emailTemplate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, EmailTemplate $emailTemplate): View
    {
        $this->authorize('update', $emailTemplate);

        return view('app.email_templates.edit', compact('emailTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        EmailTemplateUpdateRequest $request,
        EmailTemplate $emailTemplate
    ): RedirectResponse {
        $this->authorize('update', $emailTemplate);

        $validated = $request->validated();

        $emailTemplate->update($validated);

        return redirect()
            ->route('email-templates.edit', $emailTemplate)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        EmailTemplate $emailTemplate
    ): RedirectResponse {
        $this->authorize('delete', $emailTemplate);

        $emailTemplate->delete();

        return redirect()
            ->route('email-templates.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
