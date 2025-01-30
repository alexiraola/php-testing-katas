<?php

namespace App\Domain\Repositories;

use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Id;
use App\Domain\Entities\User;

interface UserRepository
{
    public function save(User $user): void;
    public function findById(Id $id): ?User;
    public function findByEmail(Email $id): ?User;
}
