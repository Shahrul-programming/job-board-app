<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    #[Validate('string|max:255')]
    public string $search = '';

    #[Validate('string|in:all,admin,guest')]
    public string $roleFilter = 'all';

    public bool $showUserForm = false;

    public $selectedUser = null;

    protected $listeners = [
        'userSaved' => 'refreshUsers',
        'userDeleted' => 'refreshUsers',
    ];

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function createUser(): void
    {
        $this->authorize('create', User::class);
        $this->selectedUser = null;
        $this->showUserForm = true;
    }

    public function editUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->authorize('update', $user);
        $this->selectedUser = $user;
        $this->showUserForm = true;
    }

    public function deleteUser(int $userId): void
    {
        $user = User::findOrFail($userId);
        $this->authorize('delete', $user);

        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');

            return;
        }

        $user->delete();
        $this->dispatch('userDeleted');
        session()->flash('success', 'User deleted successfully.');
    }

    public function closeUserForm(): void
    {
        $this->showUserForm = false;
        $this->selectedUser = null;
    }

    public function refreshUsers(): void
    {
        $this->closeUserForm();
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('email', 'like', '%'.$this->search.'%');
            })
            ->when($this->roleFilter !== 'all', function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-management', [
            'users' => $users,
        ]);
    }
}
