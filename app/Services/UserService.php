<?php

namespace App\Services;

use Illuminate\Support\Facades\Hash;
use App\Repositories\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user && Hash::check($password, $user->password)) {
            return $user;
        }
        return null;
    }

    public function register($userData)
    {
        $userData['password'] = Hash::make($userData['password']);
        return $this->userRepository->create($userData);
    }

    public function registerGuest($userData)
    {
        $userData['password'] = Hash::make(12345678);
        $getUserByEmail = $this->getUserByEmail($userData['email']);
        if(!$getUserByEmail){
            return $this->userRepository->create($userData);
        }
        return $getUserByEmail;
    }
    public function updateProfile($userId, $userData)
    {
        $user = $this->userRepository->find($userId);
        if ($user) {
            $this->userRepository->update($userId, $userData);
            return $user;
        }
        return null;
    }

    public function changePassword($userId, $oldPassword, $newPassword)
    {
        $user = $this->userRepository->find($userId);
        if ($user && Hash::check($oldPassword, $user->password)) {
            $userData = ['password' => Hash::make($newPassword)];
            $this->userRepository->update($userId, $userData);
            return true;
        }
        return false;
    }

    public function getUserByEmail($email)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user) {
            return $user;
        }
        return false;
    }

    public function getUserData($userId)
    {
        return $this->userRepository->find($userId);
    }

    public function deleteUser($userId)
    {
        $user = $this->userRepository->find($userId);
        if ($user) {
            $this->userRepository->delete($userId);
            return true;
        }
        return false;
    }
}
