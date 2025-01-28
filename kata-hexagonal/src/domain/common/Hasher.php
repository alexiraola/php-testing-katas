<?php

namespace Alex\KataHexagonal\domain\common;

class Hasher
{
    public static function hash(string $plaintext): string
    {
        return hash('sha256', $plaintext);
    }
}
