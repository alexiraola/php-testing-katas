<?php

namespace Alex\KataHexagonal\application\dtos;

class UserRegisterRequest
{
    public function __construct(public string $email, public string $password)
    {
    }
}
