<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserForm extends Component
{
    public $user = null;

    public bool $isEdit = false;

    public ?string $name = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $role = null;

    public function mount($user = null): void
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role = 'guest';
        $this->isEdit = false;

        if ($user) {
            $this->user = $user;
            $this->isEdit = true;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->role = $user->role;
            $this->password = ''; // Reset password for edit
        }
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,guest',
        ];

        if ($this->isEdit) {
            $rules['email'] = 'required|email|max:255|unique:users,email,'.$this->user->id;
            $rules['password'] = 'nullable|string|min:8';
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['password'] = 'required|string|min:8';
        }

        return $rules;
    }

    public function save(): void
    {
        if ($this->isEdit) {
            $this->authorize('update', $this->user);
        } else {
            $this->authorize('create', User::class);
        }

        $this->validate($this->rules());

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->isEdit) {
            $this->user->update($userData);
            $message = 'User updated successfully.';
        } else {
            User::create($userData);
            $message = 'User created successfully.';
        }

        $this->dispatch('userSaved');
        session()->flash('success', $message);
    }

    public function cancel(): void
    {
        $this->dispatch('userFormCancelled');
    }

    public function render()
    {
        return view('livewire.admin.user-form');
    }
}
