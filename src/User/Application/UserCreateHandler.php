<?php

namespace App\User\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserCreate;
use App\User\Domain\Model\User as UserModel;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserCreateHandler
{
    public function __construct(
        private UserInterface $userInterface,
        private UserPasswordHasherInterface $userPasswordHasher,
        private ValidateConstraints $validateConstraints,
    ) {
    }

    public function handle(UserCreate $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $user = new UserModel();
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getPassword());
        $user->setName($command->getName());
        $user->setSurnames($command->getSurname());
        $user->setEmail($command->getEmail());
        $user->setPassword($hashedPassword);
        $user->setPhone($command->getPhone());
        $user->setAddress($command->getAddress());
        $user->setCountry($command->getCountry());
        $user->setCommunity($command->getCommunity());
        $user->setRoles([$command->getRol()]);
        $this->userInterface->save($user);
    }
}
