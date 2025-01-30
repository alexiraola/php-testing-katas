<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\Common\Uuid;
use App\Domain\ValueObjects\Id;
use PHPUnit\Framework\TestCase;

class IdTest extends TestCase
{
    public function testGeneratesAValidIdentifier(): void
    {
        $id = Id::generateUniqueIdentifier();

        $this->assertTrue(isUuid($id));
    }

    public function testCreatesAnIdFromAGivenValidIdentifier(): void
    {
        $validId = Uuid::generateUuidV4();
        $id = Id::createFrom($validId);

        $this->assertEquals($id->toString(), $validId);
    }

    public function testDoesNotAllowToCreateAnIdFromAGivenInvalidIdentifier(): void
    {
        $invalidId = "invalid-id";

        $this->expectExceptionMessage("Invalid Id format");

        Id::createFrom($invalidId);
    }

    public function testIdentifiesTwoIdenticalIdentifiersAsEqual(): void
    {
        $validId = Uuid::generateUuidV4();
        $id1 = Id::createFrom($validId);
        $id2 = Id::createFrom($validId);

        $this->assertEquals($id1, $id2);
    }

    public function testIdentifiesTwoDifferentIdentifiersAsNotEqual(): void
    {
        $id1 = Id::createFrom(Uuid::generateUuidV4());
        $id2 = Id::createFrom(Uuid::generateUuidV4());

        $this->assertNotEquals($id1, $id2);
    }
}

function isUuid(Id $id): bool
{
    return preg_match('/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/', $id->toString());
}
