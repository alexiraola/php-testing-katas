<?php

namespace Alex\KataHexagonal\domain\valueObjects;

use Alex\KataHexagonal\domain\common\Hasher;
use InvalidArgumentException;

class Password
{
    private function __construct(private string $password)
    {
    }

    public function toString(): string
    {
        return $this->password;
    }

    public static function createFromPlainText(string $plaintext): Password
    {
        Password::ensureIsStrongPassword($plaintext);
        return new Password(Password::hashPlaintext($plaintext));
    }

    private static function hashPlaintext(string $plaintext): string
    {
        return Hasher::hash($plaintext);
    }

    private static function ensureIsStrongPassword(string $password): void
    {
        $errors = [];

        if (!Password::hasSixCharactersOrMore($password)) {
            $errors[] = "is too short";
        }
        if (!Password::containsNumber($password)) {
            $errors[] = "must contain a number";
        }
        if (!Password::containsLowercase($password)) {
            $errors[] = "must contain a lowercase";
        }
        if (!Password::containsUppercase($password)) {
            $errors[] = "must contain an uppercase";
        }
        if (!Password::containsUnderscore($password)) {
            $errors[] = "must contain an underscore";
        }

        if (count($errors) > 0) {
            throw new InvalidArgumentException("Password " . join(", ", $errors));
        }
    }

    private static function hasSixCharactersOrMore(string $password): bool
    {
        return strlen($password) >= 6;
    }

    private static function containsNumber(string $password): bool
    {
        return preg_match('/\d/', $password);
    }

    private static function containsLowercase(string $password): bool
    {
        return preg_match('/[a-z]/', $password);
    }

    private static function containsUppercase(string $password): bool
    {
        return preg_match('/[A-Z]/', $password);
    }

    private static function containsUnderscore(string $password): bool
    {
        return preg_match('/_/', $password);
    }
}
