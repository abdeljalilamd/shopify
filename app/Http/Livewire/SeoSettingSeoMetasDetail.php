<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SeoMeta;
use Illuminate\View\View;
use App\Models\SeoSetting;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SeoSettingSeoMetasDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public SeoSetting $seoSetting;
    public SeoMeta $seoMeta;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New SeoMeta';

    protected $rules = [
        'seoMeta.type' => ['required', 'max:255', 'string'],
        'seoMeta.key' => ['required', 'max:255', 'string'],
    ];

    public function mount(SeoSetting $seoSetting): void
    {
        $this->seoSetting = $seoSetting;
        $this->resetSeoMetaData();
    }

    public function resetSeoMetaData(): void
    {
        $this->seoMeta = new SeoMeta();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newSeoMeta(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.seo_setting_seo_metas.new_title');
        $this->resetSeoMetaData();

        $this->showModal();
    }

    public function editSeoMeta(SeoMeta $seoMeta): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.seo_setting_seo_metas.edit_title');
        $this->seoMeta = $seoMeta;

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

        if (!$this->seoMeta->seo_setting_id) {
            $this->authorize('create', SeoMeta::class);

            $this->seoMeta->seo_setting_id = $this->seoSetting->id;
        } else {
            $this->authorize('update', $this->seoMeta);
        }

        $this->seoMeta->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', SeoMeta::class);

        SeoMeta::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetSeoMetaData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->seoSetting->seoMetas as $seoMeta) {
            array_push($this->selected, $seoMeta->id);
        }
    }

    public function render(): View
    {
        return view('livewire.seo-setting-seo-metas-detail', [
            'seoMetas' => $this->seoSetting->seoMetas()->paginate(20),
        ]);
    }
}
