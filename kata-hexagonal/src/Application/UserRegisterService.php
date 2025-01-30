<?php

namespace App\Application;

use App\Application\dtos\UserRegisterRequest;
use App\Application\dtos\UserRegisterResponse;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use App\Domain\ValueObjects\Email;
use App\Domain\ValueObjects\Password;
use App\Domain\ValueObjects\Id;
use InvalidArgumentException;

class UserRegisterService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse
    {
        $this->ensureThatUserDoesNotExist($request);
        $user = $this->createUser($request);
        $this->repository->save($user);

        $dto = $user->toDto();
        return new UserRegisterResponse($dto['id'], $dto['email']);
    }

    private function ensureThatUserDoesNotExist(UserRegisterRequest $request): void
    {
        $email = Email::create($request->email);
        $foundUser = $this->repository->findByEmail($email);

        if ($foundUser) {
            throw new InvalidArgumentException("A user already exists with this email");
        }
    }

    private function createUser(UserRegisterRequest $request): User
    {
        $id = Id::generateUniqueIdentifier();
        $email = Email::create($request->email);
        $password = Password::createFromPlainText($request->password);

        return new User($id, $email, $password);
    }
}
