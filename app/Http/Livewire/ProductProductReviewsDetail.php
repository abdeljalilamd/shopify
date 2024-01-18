<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\ProductReview;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductProductReviewsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Product $product;
    public ProductReview $productReview;
    public $customersForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New ProductReview';

    protected $rules = [
        'productReview.customer_id' => ['required', 'exists:customers,id'],
        'productReview.rating' => ['required', 'numeric'],
        'productReview.text' => ['required', 'max:255', 'string'],
    ];

    public function mount(Product $product): void
    {
        $this->product = $product;
        $this->customersForSelect = Customer::pluck('address', 'id');
        $this->resetProductReviewData();
    }

    public function resetProductReviewData(): void
    {
        $this->productReview = new ProductReview();

        $this->productReview->customer_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newProductReview(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_product_reviews.new_title');
        $this->resetProductReviewData();

        $this->showModal();
    }

    public function editProductReview(ProductReview $productReview): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_product_reviews.edit_title');
        $this->productReview = $productReview;

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

        if (!$this->productReview->product_id) {
            $this->authorize('create', ProductReview::class);

            $this->productReview->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->productReview);
        }

        $this->productReview->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', ProductReview::class);

        ProductReview::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetProductReviewData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->productReviews as $productReview) {
            array_push($this->selected, $productReview->id);
        }
    }

    public function render(): View
    {
        return view('livewire.product-product-reviews-detail', [
            'productReviews' => $this->product->productReviews()->paginate(20),
        ]);
    }
}
