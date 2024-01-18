<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\View\View;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartCartItemsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Cart $cart;
    public CartItem $cartItem;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New CartItem';

    protected $rules = [
        'cartItem.product_id' => ['required', 'exists:products,id'],
        'cartItem.quantity' => ['required', 'numeric'],
    ];

    public function mount(Cart $cart): void
    {
        $this->cart = $cart;
        $this->productsForSelect = Product::pluck('title', 'id');
        $this->resetCartItemData();
    }

    public function resetCartItemData(): void
    {
        $this->cartItem = new CartItem();

        $this->cartItem->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newCartItem(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.cart_cart_items.new_title');
        $this->resetCartItemData();

        $this->showModal();
    }

    public function editCartItem(CartItem $cartItem): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.cart_cart_items.edit_title');
        $this->cartItem = $cartItem;

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

        if (!$this->cartItem->cart_id) {
            $this->authorize('create', CartItem::class);

            $this->cartItem->cart_id = $this->cart->id;
        } else {
            $this->authorize('update', $this->cartItem);
        }

        $this->cartItem->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', CartItem::class);

        CartItem::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetCartItemData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->cart->cartItems as $cartItem) {
            array_push($this->selected, $cartItem->id);
        }
    }

    public function render(): View
    {
        return view('livewire.cart-cart-items-detail', [
            'cartItems' => $this->cart->cartItems()->paginate(20),
        ]);
    }
}
