<?php

namespace App\Repositories;

use App\Models\User;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    public function all()
    {
        return User::all();
    }

    public function find($id)
    {
        return User::find($id);
    }

    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    public function create($data)
    {
        $user = User::create($data);
        $role = Role::firstOrCreate(['name' => 'attendee']);
        $user->assignRole($role->name);
        return $user;
    }

    public function update($id, $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = $this->find($id);
        $user->delete();
        return true;
    }
}
