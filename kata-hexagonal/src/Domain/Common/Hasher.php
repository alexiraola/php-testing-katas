<?php

namespace App\Domain\Common;

class Hasher
{
    public static function hash(string $plaintext): string
    {
        return hash('sha256', $plaintext);
    }
}
