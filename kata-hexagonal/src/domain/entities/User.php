<?php

namespace Alex\KataHexagonal\domain\entities;

use Alex\KataHexagonal\Domain\ValueObjects\Email;
use Alex\KataHexagonal\domain\valueObjects\Id;
use Alex\KataHexagonal\domain\valueObjects\Password;
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

    public function isMatchingPassword(Password $password): bool
    {
        return $this->password == $password;
    }

    private function ensureIsDifferentPassword(Password $password): void
    {
        if ($this->password == $password) {
            throw new InvalidArgumentException("New password must be different");
        }
    }
}
