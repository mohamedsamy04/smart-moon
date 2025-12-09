<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): User
    {
        return User::create($data);
    }

    public function findByEmail(string $email): ?User
    {
        return User::select(['id', 'name', 'email', 'password'])
            ->where('email', $email)
            ->first();
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user->fresh();
    }


    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function existsByEmail(string $email): bool
    {
        return User::where('email', $email)->exists();
    }
}
