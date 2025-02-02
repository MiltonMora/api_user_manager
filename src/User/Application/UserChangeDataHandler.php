<?php

namespace App\User\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserChangeData;
use App\User\Domain\Model\User;
use App\User\Domain\Model\User as UserModel;
use App\User\Domain\Ports\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserChangeDataHandler
{
    public function __construct(
        private Security $security,
        private UserInterface               $userInterface,
        private ValidateConstraints $validateConstraints
    )
    {}

    public function handle(UserChangeData $command): void
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }

        $user = $this->security->getUser();

        if(!$user instanceof User){
            throw new BadRequestHttpException('User not found');
        }
        $user->setName($command->getName());
        $user->setSurnames($command->getSurname());
        $this->userInterface->save($user);
    }

}
