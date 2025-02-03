<?php

namespace App\Test\Domain\Repositories;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Id;
use App\Domain\ValueObjects\Password;
use App\Infrastructure\InMemoryUserRepository;

it('finds auser by id', function () {
    $repository = new InMemoryUserRepository();
    $id = Id::generateUniqueIdentifier();
    $user = createUserById($id);

    $repository->save($user);

    $foundUser = $repository->findById($id);

    expect($foundUser)->toEqual($user);
});

it('does not find anon existing user by id', function () {
    $repository = new InMemoryUserRepository();
    $id = Id::generateUniqueIdentifier();

    $foundUser = $repository->findById($id);

    expect($foundUser)->toBeNull();
});

it('it finds auser by email', function () {
    $repository = new InMemoryUserRepository();
    $email = Email::create("test@example.com");
    $user = createUserByEmail($email);

    $repository->save($user);

    $foundUser = $repository->findByEmail($email);

    expect($foundUser)->toEqual($user);
});

it('does not find anon existing user by email', function () {
    $repository = new InMemoryUserRepository();
    $email = Email::create("test@example.com");

    $foundUser = $repository->findByEmail($email);

    expect($foundUser)->toBeNull();
});

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
