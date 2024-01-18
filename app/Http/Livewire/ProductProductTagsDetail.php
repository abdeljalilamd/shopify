<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\ProductTag;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductTagsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public ProductTag $productTag;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductTag';

    protected $rules = [
        'productTag.tag' => ['required', 'max:255', 'string'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->resetProductTagData();
    }

    public function resetProductTagData(): void
    {
        $this->productTag = new ProductTag();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductTag(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_product_tags.new_title');
        $this->resetProductTagData();

        $this->showModal();
    }

    public function editProductTag(ProductTag $productTag): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_product_tags.edit_title');
        $this->productTag = $productTag;

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

        if (!$this->productTag->product_id) {
            $this->authorize('create', ProductTag::class);

            $this->productTag->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productTag);
        }

        $this->productTag->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ProductTag::class);

        ProductTag::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductTagData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productTags as $productTag) {
            array_push($this->selected, $productTag->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-product-tags-detail', [
            'productTags' => $this->product->productTags()->paginate(20),
        ]);
    }
}
