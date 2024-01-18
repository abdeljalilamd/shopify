<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\AffiliateProgram;
use App\Models\AffiliateCommission;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AffiliateProgramAffiliateCommissionsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public AffiliateProgram $affiliateProgram;
    public AffiliateCommission $affiliateCommission;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New AffiliateCommission';

    protected $rules = [
        'affiliateCommission.amount' => ['required', 'numeric'],
    ];

    public function mount(AffiliateProgram $affiliateProgram): void
    {
        $this->affiliateProgram = $affiliateProgram;
        $this->resetAffiliateCommissionData();
    }

    public function resetAffiliateCommissionData(): void
    {
        $this->affiliateCommission = new AffiliateCommission();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newAffiliateCommission(): void
    {
        $this->editing = false;
        $this->modalTitle = trans(
            'crud.affiliate_program_affiliate_commissions.new_title'
        );
        $this->resetAffiliateCommissionData();

        $this->showModal();
    }

    public function editAffiliateCommission(
        AffiliateCommission $affiliateCommission
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.affiliate_program_affiliate_commissions.edit_title'
        );
        $this->affiliateCommission = $affiliateCommission;

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

        if (!$this->affiliateCommission->affiliate_program_id) {
            $this->authorize('create', AffiliateCommission::class);

            $this->affiliateCommission->affiliate_program_id =
                $this->affiliateProgram->id;
        } else {
            $this->authorize('update', $this->affiliateCommission);
        }

        $this->affiliateCommission->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', AffiliateCommission::class);

        AffiliateCommission::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetAffiliateCommissionData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach (
            $this->affiliateProgram->affiliateCommissions
            as $affiliateCommission
        ) {
            array_push($this->selected, $affiliateCommission->id);
        }
    }

    public function render(): View
    {
        return view('livewire.affiliate-program-affiliate-commissions-detail', [
            'affiliateCommissions' => $this->affiliateProgram
                ->affiliateCommissions()
                ->paginate(20),
        ]);
    }
}
