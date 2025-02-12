<?php

namespace App\User\Application;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserGetById;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserGetByIdHandler
{
    public function __construct(
        private UserInterface $userInterface,
        private ValidateConstraints $validateConstraints
    ){}

    public function handle(UserGetById $command): ?User
    {
        $errors = $this->validateConstraints->validate($command);
        if (count($errors) > 0) {
            throw new BadRequestHttpException(json_encode($errors));
        }
        return $this->userInterface->findById($command->getUserId());
    }

}
