<?php

namespace App\Tests\User;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Application\UserCreateHandler;
use App\User\Application\Command\UserCreate;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Commons\Helpers\ValidateConstraints;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserCreateHandlerTest extends TestCase
{
    private MockObject $userInterface;
    private MockObject $userPasswordHasher;
    private MockObject $validateConstraints;
    private UserCreateHandler $handler;

    protected function setUp(): void
    {
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->userPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);

        $this->handler = new UserCreateHandler(
            $this->userInterface,
            $this->userPasswordHasher,
            $this->validateConstraints
        );
    }

    public function testHandleSuccess(): void
    {
        $command = new UserCreate('John', 'Doe', 'securepassword', 'john.doe@example.com', '', '', '', 'ROLE_USER', '');

        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $this->userPasswordHasher
            ->method('hashPassword')
            ->willReturn('hashedpassword');

        $this->userInterface
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(User::class));

        $this->handler->handle($command);
    }

    public function testHandleValidationError(): void
    {
        $command = new UserCreate('', '', 'short', 'invalid-email', '', '', '', '', '');

        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($command);
    }

    public function testHandleInsertError(): void
    {
        $command = new UserCreate('John', 'Doe', 'securepassword', 'john.doe@example.com', '', '', '', 'ROLE_USER', '');

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
