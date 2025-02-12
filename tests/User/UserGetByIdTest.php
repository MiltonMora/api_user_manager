<?php

namespace App\Tests\User;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserGetById;
use App\User\Application\Command\UserList;
use App\User\Application\UserGetByIdHandler;
use App\User\Application\UserListHandler;
use App\User\Domain\Model\User;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserGetByIdTest extends TestCase
{
    private MockObject $userInterface;
    private MockObject $validateConstraints;
    private UserGetByIdHandler $handler;

    protected function setUp(): void
    {
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);

        $this->handler = new UserGetByIdHandler(
            $this->userInterface,
            $this->validateConstraints
        );
    }

    public function testHandleSuccess(): void
    {
        $command = new UserGetById(123);

        $this->userInterface
            ->expects($this->once())
            ->method('findById')
            ->with(123)
            ->willReturn(new User());

        $this->handler->handle($command);
    }

    public function testHandleValidationsFail(): void {
        $command = new UserGetById('');

        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($command);
    }
}
