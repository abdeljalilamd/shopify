<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Setting;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\SocialMediaLink;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingSocialMediaLinksDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Setting $setting;
    public SocialMediaLink $socialMediaLink;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SocialMediaLink';

    protected $rules = [
        'socialMediaLink.platform' => ['required', 'max:255', 'string'],
        'socialMediaLink.url' => ['required', 'url'],
    ];

    public function mount(Setting $setting): void
    {
        $this->setting = $setting;
        $this->resetSocialMediaLinkData();
    }

    public function resetSocialMediaLinkData(): void
    {
        $this->socialMediaLink = new SocialMediaLink();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSocialMediaLink(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.setting_social_media_links.new_title');
        $this->resetSocialMediaLinkData();

        $this->showModal();
    }

    public function editSocialMediaLink(SocialMediaLink $socialMediaLink): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.setting_social_media_links.edit_title');
        $this->socialMediaLink = $socialMediaLink;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        if (!$this->socialMediaLink->setting_id) {
            $this->authorize('create', SocialMediaLink::class);

            $this->socialMediaLink->setting_id = $this->setting->id;
        } else {
            $this->authorize('update', $this->socialMediaLink);
        }

        $this->socialMediaLink->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SocialMediaLink::class);

        SocialMediaLink::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSocialMediaLinkData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->setting->socialMediaLinks as $socialMediaLink) {
            array_push($this->selected, $socialMediaLink->id);
        }
    }

    public function render(): View
    {
        return view('livewire.setting-social-media-links-detail', [
            'socialMediaLinks' => $this->setting
                ->socialMediaLinks()
                ->paginate(20),
        ]);
    }
}
