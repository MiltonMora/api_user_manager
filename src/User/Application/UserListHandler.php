<?php

namespace App\User\Application;

use App\User\Application\Command\UserList;
use App\User\Domain\Model\User as UserModel;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class UserListHandler
{
    public function __construct(private UserInterface $userInterface){}

    public function handle(UserList $command): array
    {
        return $this->userInterface->listAll();
    }

}
