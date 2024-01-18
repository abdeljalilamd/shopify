<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\Product;
use Illuminate\View\View;
use App\Models\OrderItem;
use Livewire\WithPagination;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderOrderItemsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public Order $order;
    public OrderItem $orderItem;
    public $productsForSelect = [];

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New OrderItem';

    protected $rules = [
        'orderItem.product_id' => ['required', 'exists:products,id'],
        'orderItem.quantity' => ['required', 'numeric'],
    ];

    public function mount(Order $order): void
    {
        $this->order = $order;
        $this->productsForSelect = Product::pluck('title', 'id');
        $this->resetOrderItemData();
    }

    public function resetOrderItemData(): void
    {
        $this->orderItem = new OrderItem();

        $this->orderItem->product_id = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newOrderItem(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.order_order_items.new_title');
        $this->resetOrderItemData();

        $this->showModal();
    }

    public function editOrderItem(OrderItem $orderItem): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.order_order_items.edit_title');
        $this->orderItem = $orderItem;

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

        if (!$this->orderItem->order_id) {
            $this->authorize('create', OrderItem::class);

            $this->orderItem->order_id = $this->order->id;
        } else {
            $this->authorize('update', $this->orderItem);
        }

        $this->orderItem->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', OrderItem::class);

        OrderItem::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetOrderItemData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->order->orderItems as $orderItem) {
            array_push($this->selected, $orderItem->id);
        }
    }

    public function render(): View
    {
        return view('livewire.order-order-items-detail', [
            'orderItems' => $this->order->orderItems()->paginate(20),
        ]);
    }
}
