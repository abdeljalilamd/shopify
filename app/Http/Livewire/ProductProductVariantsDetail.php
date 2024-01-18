<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\ProductVariant;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductVariantsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public ProductVariant $productVariant;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductVariant';

    protected $rules = [
        'productVariant.name' => ['required', 'max:255', 'string'],
        'productVariant.price' => ['required', 'numeric'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->resetProductVariantData();
    }

    public function resetProductVariantData(): void
    {
        $this->productVariant = new ProductVariant();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductVariant(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_product_variants.new_title');
        $this->resetProductVariantData();

        $this->showModal();
    }

    public function editProductVariant(ProductVariant $productVariant): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_product_variants.edit_title');
        $this->productVariant = $productVariant;

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

        if (!$this->productVariant->product_id) {
            $this->authorize('create', ProductVariant::class);

            $this->productVariant->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productVariant);
        }

        $this->productVariant->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ProductVariant::class);

        ProductVariant::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductVariantData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productVariants as $productVariant) {
            array_push($this->selected, $productVariant->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-product-variants-detail', [
            'productVariants' => $this->product
                ->productVariants()
                ->paginate(20),
        ]);
    }
}
