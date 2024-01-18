<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;
use App\Models\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserNotificationsDetail extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    public User $user;
    public Notification $notification;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Notification';

    protected $rules = [
        'notification.content' => ['required', 'max:255', 'string'],
    ];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->resetNotificationData();
    }

    public function resetNotificationData(): void
    {
        $this->notification = new Notification();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newNotification(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_notifications.new_title');
        $this->resetNotificationData();

        $this->showModal();
    }

    public function editNotification(Notification $notification): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_notifications.edit_title');
        $this->notification = $notification;

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

        if (!$this->notification->user_id) {
            $this->authorize('create', Notification::class);

            $this->notification->user_id = $this->user->id;
        } else {
            $this->authorize('update', $this->notification);
        }

        $this->notification->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Notification::class);

        Notification::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetNotificationData();
    }

    public function toggleFullSelection(): void
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->notifications as $notification) {
            array_push($this->selected, $notification->id);
        }
    }

    public function render(): View
    {
        return view('livewire.user-notifications-detail', [
            'notifications' => $this->user->notifications()->paginate(20),
        ]);
    }
}
