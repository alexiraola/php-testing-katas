<?php

namespace App\Application\dtos;

class UserRegisterResponse
{
    public function __construct(public string $id, public string $email)
    {
    }
}
