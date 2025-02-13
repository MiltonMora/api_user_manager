<?php

namespace App\User\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserChangeStatus;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserChangeStatusHandler
{
    public function __construct(
        private UserInterface $userInterface,
        private ValidateConstraints $validateConstraints,
    ) {
    }

    public function handle(UserChangeStatus $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }
        $user = $this->userInterface->findById($command->getIdUser());

        if (!$user instanceof User) {
            throw new BadRequestHttpException();
        }

        if ((bool) $user->isActive()) {
            /**@phpstan-ignore-next-line*/
            $user->setPassword(md5(rand(100000, 999999)));
        }
        $user->setIsActive(!$user->isActive());
        $this->userInterface->save($user);
    }
}
