<?php

namespace App\Tests\User;

use App\User\Application\Command\UserList;
use App\User\Application\UserListHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Ports\UserInterface;

class UserListHandlerTest extends TestCase
{
    private MockObject $userInterface;
    private UserListHandler $handler;

    protected function setUp(): void
    {
        $this->userInterface = $this->createMock(UserInterface::class);

        $this->handler = new UserListHandler(
            $this->userInterface
        );
    }

    public function testHandleSuccessAdmin(): void
    {
        $command = new UserList();

        $this->userInterface
            ->expects($this->once())
            ->method('listAll')
            ->willReturn([]);

        $this->handler->handle($command);
    }
}
