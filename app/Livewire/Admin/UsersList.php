<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class UsersList extends Component
{
    use WithPagination;

    // This will control the modal visibility for delete confirmation
    public $confirmingDelete = false;
    public $userIdToDelete;
    public $users;

    public function mount()
    {
        $this->users = User::all()->paginate(10);
    }

    // Method to delete user
    public function deleteUser($userId)
    {
        $this->userIdToDelete = $userId;
        $this->confirmingDelete = true;
    }

    public function confirmDelete()
    {
        if ($this->userIdToDelete) {
            User::find($this->userIdToDelete)->delete();
            $this->confirmingDelete = false;
            session()->flash('message', 'User deleted successfully!');
        }
    }

    public function render()
    {
        return view('livewire.admin.users-list')->layout('layouts.app');
    }
}
