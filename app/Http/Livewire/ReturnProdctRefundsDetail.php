<?php

namespace App\Http\Livewire;

use App\Models\Refund;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\ReturnProdct;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReturnProdctRefundsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public ReturnProdct $returnProdct;
    public Refund $refund;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Refund';

    protected $rules = [
        'refund.amount' => ['required', 'numeric'],
    ];

    public function mount(ReturnProdct $returnProdct): void
    {
        $this->returnProdct = $returnProdct;
        $this->resetRefundData();
    }

    public function resetRefundData(): void
    {
        $this->refund = new Refund();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newRefund(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.return_prodct_refunds.new_title');
        $this->resetRefundData();

        $this->showModal();
    }

    public function editRefund(Refund $refund): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.return_prodct_refunds.edit_title');
        $this->refund = $refund;

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

        if (!$this->refund->returnProdct_id) {
            $this->authorize('create', Refund::class);

            $this->refund->returnProdct_id = $this->returnProdct->id;
        } else {
            $this->authorize('update', $this->refund);
        }

        $this->refund->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Refund::class);

        Refund::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetRefundData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->returnProdct->refunds as $refund) {
            array_push($this->selected, $refund->id);
        }
    }

    public function render(): View
    {
        return view('livewire.return-prodct-refunds-detail', [
            'refunds' => $this->returnProdct->refunds()->paginate(20),
        ]);
    }
}
