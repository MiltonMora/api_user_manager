<?php

namespace App\Tests\User;

use App\User\Application\Command\UserChangeData;
use App\User\Application\UserChangeDataHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Commons\Helpers\ValidateConstraints;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserChangeDataHandlerTest extends TestCase
{
    private MockObject $security;
    private MockObject $userInterface;
    private MockObject $validateConstraints;
    private UserChangeDataHandler $handler;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);

        $this->handler = new UserChangeDataHandler(
            $this->security,
            $this->userInterface,
            $this->validateConstraints
        );
    }

    public function testHandleSuccess(): void
    {
        $command = new UserChangeData('John', 'Doe');

        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn(new User());

        $this->userInterface
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->handler->handle($command);
    }

    public function testHandleValidationError(): void
    {
        $command = new UserChangeData('John', 'Doe');

        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($command);
    }

    public function testHandleInsertError(): void
    {
        $command = new UserChangeData('John', 'Doe');

        $this->security->expects($this->once())
            ->method('getUser')
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
