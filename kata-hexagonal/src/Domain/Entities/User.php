<?php

namespace App\Domain\Entities;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Id;
use App\Domain\ValueObjects\Password;
use InvalidArgumentException;

class User
{
    public function __construct(private Id $id, private Email $email, private Password $password)
    {
    }

    public function changePassword(Password $password): void
    {
        $this->ensureIsDifferentPassword($password);
        $this->password = $password;
    }

    public function isMatchingId(Id $id): bool
    {
        return $this->id == $id;
    }

    public function isMatchingPassword(Password $password): bool
    {
        return $this->password == $password;
    }

    public function isMatchingEmail(Email $email): bool
    {
        return $this->email == $email;
    }

    public function toDto()
    {
        return [
          'id' => $this->id->toString(),
          'email' => $this->email->toString(),
          'password' => $this->password->toString()
        ];
    }

    private function ensureIsDifferentPassword(Password $password): void
    {
        if ($this->password == $password) {
            throw new InvalidArgumentException("New password must be different");
        }
    }
}
