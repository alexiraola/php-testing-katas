<?php

namespace App\Domain\ValueObjects;

use App\Domain\Common\Uuid;
use InvalidArgumentException;

class Id
{
    private function __construct(private string $id)
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function generateUniqueIdentifier(): Id
    {
        return new Id(Uuid::generateUuidV4());
    }

    public static function createFrom(string $id): Id
    {
        Id::ensureIsValidId($id);
        return new Id($id);
    }

    private static function ensureIsValidId(string $id): void
    {
        $isValidId = preg_match('/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/', $id);

        if (!$isValidId) {
            throw new InvalidArgumentException("Invalid Id format");
        }
    }
}
