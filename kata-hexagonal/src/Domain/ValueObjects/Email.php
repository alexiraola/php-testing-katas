<?php

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

class Email
{
    private function __construct(private string $email)
    {
    }

    public static function create(string $email): Email
    {
        Email::ensureIsValidEmail($email);
        return new Email($email);
    }

    private static function ensureIsValidEmail(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address: $email");
        }
    }

    public function toString(): string
    {
        return $this->email;
    }
}
