<?php

namespace App\Test\Domain\ValueObjects;

use App\Domain\Common\Uuid;
use App\Domain\ValueObjects\Id;

it('generates avalid identifier', function () {
    $id = Id::generateUniqueIdentifier();

    expect(isUuid($id))->toBeTrue();
});

it('creates an id from agiven valid identifier', function () {
    $validId = Uuid::generateUuidV4();
    $id = Id::createFrom($validId);

    expect($validId)->toEqual($id->toString());
});

it('does not allow to create an id from agiven invalid identifier', function () {
    Id::createFrom("invalid-id");
})->throws("Invalid Id format");

it('identifies two identical identifiers as equal', function () {
    $validId = Uuid::generateUuidV4();
    $id1 = Id::createFrom($validId);
    $id2 = Id::createFrom($validId);

    expect($id2)->toEqual($id1);
});

it('identifies two different identifiers as not equal', function () {
    $id1 = Id::createFrom(Uuid::generateUuidV4());
    $id2 = Id::createFrom(Uuid::generateUuidV4());

    expect($id1)->not()->toEqual($id2);
});

function isUuid(Id $id): bool
{
    return preg_match('/[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-4[0-9a-fA-F]{3}-[89abAB][0-9a-fA-F]{3}-[0-9a-fA-F]{12}/', $id->toString());
}
