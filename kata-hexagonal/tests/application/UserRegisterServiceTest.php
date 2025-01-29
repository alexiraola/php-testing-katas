<?php

namespace Tests\application;

use Alex\KataHexagonal\domain\valueObjects\Email;
use Alex\KataHexagonal\application\UserRegisterService;
use Alex\KataHexagonal\application\dtos\UserRegisterRequest;
use Alex\KataHexagonal\infrastructure\InMemoryUserRepository;
use PHPUnit\Framework\TestCase;

class UserRegisterServiceTest extends TestCase
{
    public function testRegistersANewUserSuccessfullyWhenGivenCredentialsAreValid(): void
    {
        $repository = new InMemoryUserRepository();
        $service = new UserRegisterService($repository);

        $service->register(createRegisterRequest());

        $expectedEmail = Email::create(createRegisterRequest()->email);

        $foundUser = $repository->findByEmail($expectedEmail);

        $this->assertTrue($foundUser->isMatchingEmail($expectedEmail));
    }

    public function testDoesNotAllowToRegisterANewUserWhenAnotherOneWithTheSameEmailAlreadyExists(): void
    {
        $repository = new InMemoryUserRepository();
        $service = new UserRegisterService($repository);

        $this->expectExceptionMessage("A user already exists with this email");

        $service->register(createRegisterRequest());
        $service->register(createRegisterRequest());
    }
}

function createRegisterRequest(): UserRegisterRequest
{
    return new UserRegisterRequest("test@example.com", "TestPassword123_");
}
