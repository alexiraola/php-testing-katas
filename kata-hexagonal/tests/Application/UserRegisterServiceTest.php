<?php

namespace App\Test\Application;

use App\Application\UserRegisterService;
use App\Application\dtos\UserRegisterRequest;
use App\Domain\ValueObjects\Email;
use App\Infrastructure\InMemoryUserRepository;

it('registers anew user successfully when given credentials are valid', function () {
    $repository = new InMemoryUserRepository();
    $service = new UserRegisterService($repository);

    $service->register(createRegisterRequest());

    $expectedEmail = Email::create(createRegisterRequest()->email);

    $foundUser = $repository->findByEmail($expectedEmail);

    expect($foundUser->isMatchingEmail($expectedEmail))->toBeTrue();
});

it('does not allow to register anew user when another one with the same email already exists', function () {
    $repository = new InMemoryUserRepository();
    $service = new UserRegisterService($repository);

    $service->register(createRegisterRequest());
    $service->register(createRegisterRequest());
})->throws("A user already exists with this email");

function createRegisterRequest(): UserRegisterRequest
{
    return new UserRegisterRequest("test@example.com", "TestPassword123_");
}
