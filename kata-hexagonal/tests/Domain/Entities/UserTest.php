<?php

namespace App\Test\Domain\Entities;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Id;
use App\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testChangesThePasswordWhenADifferentOneIsProvided(): void
    {
        $initialPassword = Password::createFromPlainText("Safepass123_");
        $user = createUser($initialPassword);
        $newPassword = Password::createFromPlainText("AnotherSafepass123_");

        $user->changePassword($newPassword);

        $this->assertTrue($user->isMatchingPassword($newPassword));
    }

    public function testDoesNotAllowToChangeThePasswordWhenTheGivenOneIsTheSame(): void
    {
        $initialPassword = Password::createFromPlainText("Safepass123_");
        $user = createUser($initialPassword);

        $this->expectExceptionMessage("New password must be different");

        $user->changePassword($initialPassword);
    }
}

function createUser(Password $password): User
{
    $id = Id::generateUniqueIdentifier();
    $email = Email::create("test@example.com");

    return new User($id, $email, $password);
}
