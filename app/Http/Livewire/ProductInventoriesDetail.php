<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\Inventory;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductInventoriesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public Inventory $inventory;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Inventory';

    protected $rules = [
        'inventory.quantity' => ['required', 'numeric'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->resetInventoryData();
    }

    public function resetInventoryData(): void
    {
        $this->inventory = new Inventory();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newInventory(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_inventories.new_title');
        $this->resetInventoryData();

        $this->showModal();
    }

    public function editInventory(Inventory $inventory): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_inventories.edit_title');
        $this->inventory = $inventory;

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

        if (!$this->inventory->product_id) {
            $this->authorize('create', Inventory::class);

            $this->inventory->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->inventory);
        }

        $this->inventory->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Inventory::class);

        Inventory::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetInventoryData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->inventories as $inventory) {
            array_push($this->selected, $inventory->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-inventories-detail', [
            'inventories' => $this->product->inventories()->paginate(20),
        ]);
    }
}
