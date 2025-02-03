<?php

namespace App\Test\Domain\Entities;

use App\Domain\Entities\User;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Id;
use App\Domain\ValueObjects\Password;

it('changes the password when adifferent one is provided', function () {
    $initialPassword = Password::createFromPlainText("Safepass123_");
    $user = createUser($initialPassword);
    $newPassword = Password::createFromPlainText("AnotherSafepass123_");

    $user->changePassword($newPassword);

    expect($user->isMatchingPassword($newPassword))->toBeTrue();
});

it('does not allow to change the password when the given one is the same', function () {
    $initialPassword = Password::createFromPlainText("Safepass123_");
    $user = createUser($initialPassword);

    $user->changePassword($initialPassword);
})->throws("New password must be different");

function createUser(Password $password): User
{
    $id = Id::generateUniqueIdentifier();
    $email = Email::create("test@example.com");

    return new User($id, $email, $password);
}
