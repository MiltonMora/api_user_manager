<?php

namespace App\Application\User;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Application\User\Command\UserCreate;
use App\Domain\User\Model\User as UserModel;
use App\Domain\User\Ports\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class UserCreateHandler
{
    public function __construct(
        private UserInterface               $userInterface,
        private UserPasswordHasherInterface $userPasswordHasher,
        private ValidatorInterface $validator
    )
    {}

    public function handle(UserCreate $command): void
    {
        $errors = $this->validator->validate($command);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] = $error->getMessage();
            }
            throw new BadRequestHttpException(json_encode($errorMessages));
        }


        $user = new UserModel();
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getPassword());
        $user->setName($command->getName());
        $user->setEmail($command->getEmail());
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_USER']);
        $this->userInterface->save($user);
    }

}
