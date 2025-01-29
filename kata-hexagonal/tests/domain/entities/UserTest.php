<?php

namespace Tests\domain\entities;

use Alex\KataHexagonal\domain\valueObjects\Email;
use Alex\KataHexagonal\domain\entities\User;
use Alex\KataHexagonal\domain\valueObjects\Id;
use Alex\KataHexagonal\domain\valueObjects\Password;
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
