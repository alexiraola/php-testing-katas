<?php

namespace Alex\KataHexagonal\domain\repositories;

use Alex\KataHexagonal\Domain\ValueObjects\Email;
use Alex\KataHexagonal\domain\entities\User;
use Alex\KataHexagonal\domain\valueObjects\Id;

interface UserRepository
{
    public function save(User $user): void;
    public function findById(Id $id): ?User;
    public function findByEmail(Email $id): ?User;
}
