<?php

namespace Alex\KataHexagonal\infrastructure;

use Alex\KataHexagonal\Domain\ValueObjects\Email;
use Alex\KataHexagonal\domain\entities\User;
use Alex\KataHexagonal\domain\repositories\UserRepository;
use Alex\KataHexagonal\domain\valueObjects\Id;

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
