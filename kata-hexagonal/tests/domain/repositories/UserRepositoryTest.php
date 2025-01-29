<?php

namespace Tests\domain\repositories;

use Alex\KataHexagonal\domain\valueObjects\Email;
use Alex\KataHexagonal\domain\entities\User;
use Alex\KataHexagonal\infrastructure\InMemoryUserRepository;
use Alex\KataHexagonal\domain\valueObjects\Id;
use Alex\KataHexagonal\domain\valueObjects\Password;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testFindsAUserById(): void
    {
        $repository = new InMemoryUserRepository();
        $id = Id::generateUniqueIdentifier();
        $user = createUserById($id);

        $repository->save($user);

        $foundUser = $repository->findById($id);

        $this->assertEquals($user, $foundUser);
    }

    public function testDoesNotFindANonExistingUserById(): void
    {
        $repository = new InMemoryUserRepository();
        $id = Id::generateUniqueIdentifier();

        $foundUser = $repository->findById($id);

        $this->assertNull($foundUser);
    }

    public function testItFindsAUserByEmail(): void
    {
        $repository = new InMemoryUserRepository();
        $email = Email::create("test@example.com");
        $user = createUserByEmail($email);

        $repository->save($user);

        $foundUser = $repository->findByEmail($email);

        $this->assertEquals($user, $foundUser);
    }

    public function testDoesNotFindANonExistingUserByEmail(): void
    {
        $repository = new InMemoryUserRepository();
        $email = Email::create("test@example.com");

        $foundUser = $repository->findByEmail($email);

        $this->assertNull($foundUser);
    }
}

function createUserById(Id $id): User
{
    $email = Email::create("test@example.com");
    $password = Password::createFromPlainText("SecurePass123_");
    return new User($id, $email, $password);
}

function createUserByEmail(Email $email): User
{
    $id = Id::generateUniqueIdentifier();
    $password = Password::createFromPlainText("SecurePass123_");
    return new User($id, $email, $password);
}
