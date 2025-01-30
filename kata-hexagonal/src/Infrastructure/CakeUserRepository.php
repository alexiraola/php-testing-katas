<?php

namespace App\Infrastructure;

use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\Email;
use App\Domain\Entities\User;
use App\Domain\ValueObjects\Id;
use App\Domain\ValueObjects\Password;
use Cake\Datasource\ConnectionManager;

class CakeUserRepository implements UserRepository
{
    private $connection;

    public function __construct()
    {
        $this->connection = ConnectionManager::get('default');
    }

    public function save(User $user): void
    {
        $dto = $user->toDto();

        $query = "INSERT INTO users (id, email, password) VALUES (:id, :email, :password)";
        $stmt = $this->connection->getDriver()->prepare($query);
        $stmt->bindValue('id', $dto['id'], 'string');
        $stmt->bindValue('email', $dto['email'], 'string');
        $stmt->bindValue('password', $dto['password'], 'string');
        $stmt->execute();
    }

    public function findById(Id $id): ?User
    {
        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->connection->getDriver()->prepare($query);
        $stmt->bindValue('id', $id->toString(), 'string');
        $stmt->execute();

        $user = $stmt->fetch('assoc');

        if (!$user) {
            return null;
        }

        $email = Email::create($user->email);
        $password = Password::createFromHash($user->password);

        return new User($id, $email, $password);
    }

    public function findByEmail(Email $email): ?User
    {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->connection->getDriver()->prepare($query);
        $stmt->bindValue('email', $email->toString(), 'string');
        $stmt->execute();

        $user = $stmt->fetch('assoc');

        if (!$user) {
            return null;
        }

        $id = Id::createFrom($user['id']);
        $password = Password::createFromHash($user['password']);

        return new User($id, $email, $password);
    }
}
