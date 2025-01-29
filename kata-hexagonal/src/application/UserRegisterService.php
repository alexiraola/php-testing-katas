<?php

namespace Alex\KataHexagonal\application;

use Alex\KataHexagonal\domain\valueObjects\Email;
use Alex\KataHexagonal\application\dtos\UserRegisterRequest;
use Alex\KataHexagonal\domain\entities\User;
use Alex\KataHexagonal\domain\repositories\UserRepository;
use Alex\KataHexagonal\domain\valueObjects\Id;
use Alex\KataHexagonal\domain\valueObjects\Password;
use InvalidArgumentException;

class UserRegisterService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function register(UserRegisterRequest $request): void
    {
        $this->ensureThatUserDoesNotExist($request);
        $user = $this->createUser($request);
        $this->repository->save($user);
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
