<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\ValueObjects\Password;

  it('creates apassword when the given value meets the requirements for astrong password', function () {
      $password = Password::createFromPlainText("SecurePass123_");

      expect($password)->toBeObject();
  });

  it('fails when the password is too short', function () {
      $password = Password::createFromPlainText("1aaA_");
  })->throws("Password is too short");

  it('fails when the password is missing anumber', function () {
      $password = Password::createFromPlainText("aaaaaA_");
  })->throws("Password must contain a number");

  it('fails when the password is missing alowercase', function () {
      $password = Password::createFromPlainText("A1234_");
  })->throws("Password must contain a lowercase");

  it('fails when the password is missing an uppercase', function () {
      $password = Password::createFromPlainText("a1234_");
  })->throws("Password must contain an uppercase");

  it('fails when the password is missing an underscore', function () {
      $password = Password::createFromPlainText("aA12345");
  })->throws("Password must contain an underscore");

  it('fails when the password is missing several requirements', function () {
      $password = Password::createFromPlainText("abc");
  })->throws("Password is too short, must contain a number, must contain an uppercase, must contain an underscore");

  it('ensures password is hashed', function () {
      $plaintext = "SecurePass123_";
      $password = Password::createFromPlainText($plaintext);
      $hashedValue = $password->toString();

      expect($hashedValue)->not()->toEqual($plaintext);
      expect(64)->toEqual(strlen($hashedValue));
      expect(isHashed($hashedValue))->toBeTrue();
  });

  it('matches when some given passwords are the same', function () {
      $plaintext = "SecurePass123_";
      $aPassword = Password::createFromPlainText($plaintext);
      $anotherPassword = Password::createFromPlainText($plaintext);

      expect($anotherPassword)->toEqual($aPassword);
  });

  it('does not match when some given passwords are different', function () {
      $aPassword = Password::createFromPlainText("SecurePass123_");
      $anotherPassword = Password::createFromPlainText("DifferentPass123_");

      expect($aPassword)->not()->toEqual($anotherPassword);
  });

function isHashed(string $hashedValue): bool
{
    return preg_match('/[a-f-F0-9]{64}/', $hashedValue);
}
