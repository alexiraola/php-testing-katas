<?php

namespace App\Infrastructure;

use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\Email;
use App\Domain\Entities\User;
use App\Domain\ValueObjects\Id;

class InMemoryUserRepository implements UserRepository
{
    private $users = [];

    public function save(User $user): void
    {
        $this->users[] = $user;
    }

    public function findById(Id $id): ?User
    {
        $result = array_filter($this->users, function (User $user) use ($id) {
            return $user->isMatchingId($id);
        });
        return $result[0] ?? null;
    }

    public function findByEmail(Email $email): ?User
    {
        $result = array_filter($this->users, function (User $user) use ($email) {
            return $user->isMatchingEmail($email);
        });
        return $result[0] ?? null;
    }
}
