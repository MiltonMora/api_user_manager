<?php

namespace App\Tests\User;

use App\Commons\Helpers\ValidateConstraints;
use App\User\Application\Command\UserChangePassword;
use App\User\Application\UserChangePasswordHandler;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;

class UserChangePasswordHandlerTest extends TestCase
{
    private MockObject $security;
    private MockObject $userInterface;
    private MockObject $userPasswordHasher;

    private MockObject $validateConstraints;
    private UserChangePasswordHandler $handler;

    protected function setUp(): void
    {
        $this->security = $this->createMock(Security::class);
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->userPasswordHasher = $this->createMock(UserPasswordHasher::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);

        $this->handler = new UserChangePasswordHandler(
            $this->security,
            $this->userPasswordHasher,
            $this->userInterface,
            $this->validateConstraints
        );
    }

    public function testHandleSuccessAdmin(): void
    {
        $command = new UserChangePassword('securePassword');

        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn(new User());

        $this->userInterface->expects($this->never())
            ->method('findById');

        $this->userInterface
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->handler->handle($command);
    }
    public function testHandleSuccessMe(): void
    {
        $command = new UserChangePassword('securePassword', 123);

        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $this->security->expects($this->never())
            ->method('getUser');

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
        $command = new UserChangePassword('');

        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($command);
    }

    public function testHandleInsertError(): void
    {
        $command = new UserChangePassword('securePassword');

        $this->security->expects($this->once())
            ->method('getUser')
            ->willReturn(new User());

        $this->userInterface->expects($this->never())
            ->method('findById');

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
