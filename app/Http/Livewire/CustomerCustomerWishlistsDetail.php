<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\CustomerWishlist;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerCustomerWishlistsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Customer $customer;
    public CustomerWishlist $customerWishlist;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New CustomerWishlist';

    protected $rules = [
        'customerWishlist.product_id' => ['required', 'exists:products,id'],
    ];

    public function mount(Customer $customer): void
    {
        $this->customer = $customer;
        $this->productsForSelect = Product::pluck('title', 'id');
        $this->resetCustomerWishlistData();
    }

    public function resetCustomerWishlistData(): void
    {
        $this->customerWishlist = new CustomerWishlist();

        $this->customerWishlist->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCustomerWishlist(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.customer_customer_wishlists.new_title');
        $this->resetCustomerWishlistData();

        $this->showModal();
    }

    public function editCustomerWishlist(
        CustomerWishlist $customerWishlist
    ): void {
        $this->editing = true;
        $this->modalTitle = trans(
            'crud.customer_customer_wishlists.edit_title'
        );
        $this->customerWishlist = $customerWishlist;

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

        if (!$this->customerWishlist->customer_id) {
            $this->authorize('create', CustomerWishlist::class);

            $this->customerWishlist->customer_id = $this->customer->id;
        } else {
            $this->authorize('update', $this->customerWishlist);
        }

        $this->customerWishlist->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', CustomerWishlist::class);

        CustomerWishlist::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCustomerWishlistData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->customer->customerWishlists as $customerWishlist) {
            array_push($this->selected, $customerWishlist->id);
        }
    }

    public function render(): View
    {
        return view('livewire.customer-customer-wishlists-detail', [
            'customerWishlists' => $this->customer
                ->customerWishlists()
                ->paginate(20),
        ]);
    }
}
