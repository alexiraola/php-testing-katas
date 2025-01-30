<?php

namespace App\Application\dtos;

class UserRegisterRequest
{
    public function __construct(public string $email, public string $password)
    {
    }
}
