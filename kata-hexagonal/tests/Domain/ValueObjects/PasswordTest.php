<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\ValueObjects\Password;
use PHPUnit\Framework\TestCase;

class PasswordTest extends TestCase
{
    public function testCreatesAPasswordWhenTheGivenValueMeetsTheRequirementsForAStrongPassword(): void
    {
        $password = Password::createFromPlainText("SecurePass123_");

        $this->assertIsObject($password);
    }

    public function testFailsWhenThePasswordIsTooShort(): void
    {
        $this->expectExceptionMessage("Password is too short");
        $password = Password::createFromPlainText("1aaA_");
    }

    public function testFailsWhenThePasswordIsMissingANumber(): void
    {
        $this->expectExceptionMessage("Password must contain a number");
        $password = Password::createFromPlainText("aaaaaA_");
    }

    public function testFailsWhenThePasswordIsMissingALowercase(): void
    {
        $this->expectExceptionMessage("Password must contain a lowercase");
        $password = Password::createFromPlainText("A1234_");
    }

    public function testFailsWhenThePasswordIsMissingAnUppercase(): void
    {
        $this->expectExceptionMessage("Password must contain an uppercase");
        $password = Password::createFromPlainText("a1234_");
    }

    public function testFailsWhenThePasswordIsMissingAnUnderscore(): void
    {
        $this->expectExceptionMessage("Password must contain an underscore");
        $password = Password::createFromPlainText("aA12345");
    }

    public function testFailsWhenThePasswordIsMissingSeveralRequirements(): void
    {
        $this->expectExceptionMessage("Password is too short, must contain a number, must contain an uppercase, must contain an underscore");
        $password = Password::createFromPlainText("abc");
    }

    public function testEnsuresPasswordIsHashed(): void
    {
        $plaintext = "SecurePass123_";
        $password = Password::createFromPlainText($plaintext);
        $hashedValue = $password->toString();

        $this->assertNotEquals($hashedValue, $plaintext);
        $this->assertEquals(strlen($hashedValue), 64);
        $this->assertTrue(isHashed($hashedValue));
    }

    public function testMatchesWhenSomeGivenPasswordsAreTheSame(): void
    {
        $plaintext = "SecurePass123_";
        $aPassword = Password::createFromPlainText($plaintext);
        $anotherPassword = Password::createFromPlainText($plaintext);

        $this->assertEquals($aPassword, $anotherPassword);
    }

    public function testDoesNotMatchWhenSomeGivenPasswordsAreDifferent(): void
    {
        $aPassword = Password::createFromPlainText("SecurePass123_");
        $anotherPassword = Password::createFromPlainText("DifferentPass123_");

        $this->assertNotEquals($aPassword, $anotherPassword);
    }
}

function isHashed(string $hashedValue): bool
{
    return preg_match('/[a-f-F0-9]{64}/', $hashedValue);
}
