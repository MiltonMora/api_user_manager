<?php

namespace App\Tests\Record;

use App\Record\Application\Command\MedicalRecordCreate;
use App\Record\Application\MedicalRecordCreateHandler;
use App\Record\Domain\Model\MedicalRecord;
use App\Record\Domain\Ports\MedicalRecordInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use App\Commons\Helpers\ValidateConstraints;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class MedicalRecordHandlerTest extends TestCase
{
    private MockObject $validateConstraints;
    private MockObject $medicalRecord;
    private MockObject $userInterface;
    private MedicalRecordCreateHandler $handler;

    private MedicalRecordCreate $command;
    protected function setUp(): void
    {
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);
        $this->medicalRecord = $this->createMock(MedicalRecordInterface::class);
        $this->userInterface = $this->createMock(UserInterface::class);

        $this->handler = new MedicalRecordCreateHandler(
            $this->validateConstraints,
            $this->medicalRecord,
            $this->userInterface,
        );

        $this->command = new MedicalRecordCreate(
            123,
            123,
            "Es feo",
            "medicina magica",
            new \DateTime("08-03-2025")
        );
    }

    public function testHandleSuccess(): void
    {
        $this->validateConstraints
            ->method('validate')
            ->willReturn([]);

        $doctor = new User();
        $doctor->setRoles([User::ROLE_DOCTOR]);
        $this->userInterface
            ->expects($this->exactly(2))
            ->method('findById')
            ->with(123)
            ->willReturnMap([
                [$this->command->getDoctorId(), $doctor],
                [$this->command->getUserId(), new User()]
            ]);

        $this->medicalRecord
            ->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(MedicalRecord::class));

        $this->handler->handle($this->command);
    }

    public function testHandleValidationError(): void
    {
        $this->validateConstraints
            ->method('validate')
            ->willReturn(['Invalid input']);

        $this->expectException(BadRequestHttpException::class);

        $this->handler->handle($this->command);
    }

    public function testHandleInsertError(): void
    {
        $doctor = new User();
        $doctor->setRoles([User::ROLE_DOCTOR]);
        $this->userInterface
            ->expects($this->exactly(2))
            ->method('findById')
            ->with(123)
            ->willReturnMap([
                [$this->command->getDoctorId(), $doctor],
                [$this->command->getUserId(), new User()]
            ]);

        $this->medicalRecord
            ->expects($this->once())
            ->method('save')
            ->willThrowException(
                new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador')
            );

        $this->expectException(\Exception::class);

        $this->handler->handle($this->command);
    }
}
