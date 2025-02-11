<?php

namespace App\Tests\User;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserChangeStatus;
use App\User\Application\UserChangeStatusHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserChangeStatusHandlerTest extends TestCase
{
    private MockObject $userInterface;

    private MockObject $validateConstraints;
    private UserChangeStatusHandler $handler;

    protected function setUp(): void
    {
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);

        $this->handler = new UserChangeStatusHandler(
            $this->userInterface,
            $this->validateConstraints
        );
    }

    public function testHandleSuccessAdmin(): void
    {
        $command = new UserChangeStatus(123);

        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $this->userInterface->expects($this->once())
            ->method('findById')
            ->with(123)
            ->willReturn(new User());

        $this->userInterface
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->handler->handle($command);
    }

    public function testHandleValidationError(): void
    {
        $command = new UserChangeStatus('');

        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($command);
    }

    public function testHandleInsertError(): void
    {
        $command = new UserChangeStatus(123);

        $this->userInterface->expects($this->once())
            ->method('findById')
            ->with(123)
            ->willReturn(new User());

        $this->userInterface
            ->expects($this->once())
            ->method('save')
            ->willThrowException(
                new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador')
            );

        $this->expectException(\Exception::class);

        $this->handler->handle($command);
    }
}
