<?php

namespace App\User\Application;

use App\User\Application\Command\UserChangeStatus;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserChangeStatusHandler
{
    public function __construct(
        private UserInterface $userInterface
    ){}

    public function handle(UserChangeStatus $command): void
    {
        $user = $this->userInterface->findById($command->getIdUser());

        if(!$user instanceof User) {
            throw new BadRequestHttpException();
        }

        if (!!$user->isActive()) {
            $user->setPassword(md5(rand(100000, 999999)));
        }
        $user->setIsActive(!$user->isActive());
        $this->userInterface->save($user);
    }

}
