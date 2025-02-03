<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\ValueObjects\Email;
use InvalidArgumentException;

it('creates an email for agiven address in acorrect format', function () {
    $email = Email::create("example@example.com");
    expect($email->toString())->toEqual("example@example.com");
});

it('does not allow creating an email for agiven incorrectly formatted address', function (string $email) {
    $email = Email::create($email);
})->with(["invalid", "test@examplecom", "testexample.com"])
  ->throws(InvalidArgumentException::class);

it('considers two emails with the same address as equal', function () {
    $aEmail = Email::create("example@example.com");
    $otherEmail = Email::create("example@example.com");

    expect($otherEmail)->toEqual($aEmail);
});

it('differentiates between two emails with different address', function () {
    $aEmail = Email::create("example@example.com");
    $otherEmail = Email::create("anotherexample@example.com");

    expect($aEmail)->not()->toEqual($otherEmail);
});
