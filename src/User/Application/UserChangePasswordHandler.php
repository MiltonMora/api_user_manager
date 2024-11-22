<?php

namespace App\User\Application;

use App\User\Application\Command\UserChangePassword;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserChangePasswordHandler
{
    public function __construct(
        private Security $security,
        private UserPasswordHasherInterface $userPasswordHasher,
        private UserInterface $userInterface
    ){}

    public function handle(UserChangePassword $command): void
    {

        $user = $this->security->getUser();
        if(!$user instanceof User) {
            throw new BadRequestHttpException();
        }
        $hashedPassword = $this->userPasswordHasher->hashPassword($user, $command->getNewPassword());
        $user->setPassword($hashedPassword);
        $this->userInterface->save($user);
    }

}
