<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\ProductAttribute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductAttributesDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public ProductAttribute $productAttribute;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductAttribute';

    protected $rules = [
        'productAttribute.name' => ['required', 'max:255', 'string'],
        'productAttribute.value' => ['required', 'max:255', 'string'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->resetProductAttributeData();
    }

    public function resetProductAttributeData(): void
    {
        $this->productAttribute = new ProductAttribute();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductAttribute(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_product_attributes.new_title');
        $this->resetProductAttributeData();

        $this->showModal();
    }

    public function editProductAttribute(
        ProductAttribute $productAttribute
    ): void {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_product_attributes.edit_title');
        $this->productAttribute = $productAttribute;

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

        if (!$this->productAttribute->product_id) {
            $this->authorize('create', ProductAttribute::class);

            $this->productAttribute->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productAttribute);
        }

        $this->productAttribute->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ProductAttribute::class);

        ProductAttribute::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductAttributeData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productAttributes as $productAttribute) {
            array_push($this->selected, $productAttribute->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-product-attributes-detail', [
            'productAttributes' => $this->product
                ->productAttributes()
                ->paginate(20),
        ]);
    }
}
