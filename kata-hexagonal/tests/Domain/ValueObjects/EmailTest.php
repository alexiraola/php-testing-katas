<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\ValueObjects\Email;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testCreatesAnEmailForAGivenAddressInACorrectFormat(): void
    {
        $email = Email::create("example@example.com");
        $this->assertEquals("example@example.com", $email->toString());
    }

    public function testDoesNotAllowCreatingAnEmailForAGivenIncorrectlyFormattedAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $email = Email::create("invalid");
    }

    public function testConsidersTwoEmailsWithTheSameAddressAsEqual(): void
    {
        $aEmail = Email::create("example@example.com");
        $otherEmail = Email::create("example@example.com");

        $this->assertEquals($aEmail, $otherEmail);
    }

    public function testDifferentiatesBetweenTwoEmailsWithDifferentAddress(): void
    {
        $aEmail = Email::create("example@example.com");
        $otherEmail = Email::create("anotherexample@example.com");

        $this->assertNotEquals($aEmail, $otherEmail);
    }
}
