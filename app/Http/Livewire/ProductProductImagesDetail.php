<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\ProductImage;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductImagesDetail extends Component
{
    use WithPagination;
    use WithFileUploads;
    use AuthorizesRequests;

    public Product $product;
    public ProductImage $productImage;
    public $productImageImageUrl;
    public $productImageImage;
    public $uploadIteration = 0;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductImage';

    protected $rules = [
        'productImageImageUrl' => ['nullable', 'image', 'max:1024'],
        'productImageImage' => ['nullable', 'image', 'max:1024'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->resetProductImageData();
    }

    public function resetProductImageData(): void
    {
        $this->productImage = new ProductImage();

        $this->productImageImageUrl = null;
        $this->productImageImage = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductImage(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_product_images.new_title');
        $this->resetProductImageData();

        $this->showModal();
    }

    public function editProductImage(ProductImage $productImage): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_product_images.edit_title');
        $this->productImage = $productImage;

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

        if (!$this->productImage->product_id) {
            $this->authorize('create', ProductImage::class);

            $this->productImage->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productImage);
        }

        if ($this->productImageImageUrl) {
            $this->productImage->image_url = $this->productImageImageUrl->store(
                'public'
            );
        }

        if ($this->productImageImage) {
            $this->productImage->image = $this->productImageImage->store(
                'public'
            );
        }

        $this->productImage->save();

        $this->uploadIteration++;

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ProductImage::class);

        collect($this->selected)->each(function (string $id) {
            $productImage = ProductImage::findOrFail($id);

            if ($productImage->image_url) {
                Storage::delete($productImage->image_url);
            }

            if ($productImage->image) {
                Storage::delete($productImage->image);
            }

            $productImage->delete();
        });

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductImageData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productImages as $productImage) {
            array_push($this->selected, $productImage->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-product-images-detail', [
            'productImages' => $this->product->productImages()->paginate(20),
        ]);
    }
}
