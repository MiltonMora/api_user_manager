<?php

namespace App\User\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserChangePassword;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserChangePasswordHandler
{
    public function __construct(
        private Security $security,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserInterface $userInterface,
        private ValidateConstraints $validateConstraints,
    ) {
    }

    public function handle(UserChangePassword $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $user = is_null($command->getIdUser())
            ? $this->security->getUser()
            : $this->userInterface->findById($command->getIdUser());

        if (!$user instanceof User) {
            throw new BadRequestHttpException();
        }

        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getNewPassword());
        $user->setPassword($hashedPassword);
        $this->userInterface->save($user);
    }
}
