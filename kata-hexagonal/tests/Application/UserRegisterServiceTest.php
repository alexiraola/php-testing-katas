<?php

namespace App\Test\Application;

use App\Application\UserRegisterService;
use App\Application\dtos\UserRegisterRequest;
use App\Domain\ValueObjects\Email;
use App\Infrastructure\InMemoryUserRepository;
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
