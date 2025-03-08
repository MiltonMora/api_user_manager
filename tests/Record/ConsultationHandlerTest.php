<?php

namespace App\Tests\Record;

use App\Record\Application\Command\ConsultationCreate;
use App\Record\Application\Command\MedicalRecordCreate;
use App\Record\Application\ConsultationCreateHandler;
use App\Record\Application\MedicalRecordCreateHandler;
use App\Record\Domain\Model\MedicalRecord;
use App\Record\Domain\Ports\ConsultationInterface;
use App\Record\Domain\Ports\MedicalRecordInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\User\Domain\Model\User;
use App\User\Domain\Ports\UserInterface;
use App\Commons\Helpers\ValidateConstraints;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ConsultationHandlerTest extends TestCase
{
    private MockObject $validateConstraints;
    private MockObject $medicalRecord;
    private MockObject $userInterface;
    private MockObject $consultationInterface;
    private ConsultationCreateHandler $handler;

    private ConsultationCreate $command;
    protected function setUp(): void
    {
        $this->validateConstraints = $this->createMock(ValidateConstraints::class);
        $this->medicalRecord = $this->createMock(MedicalRecordInterface::class);
        $this->userInterface = $this->createMock(UserInterface::class);
        $this->consultationInterface = $this->createMock(ConsultationInterface::class);

        $this->handler = new ConsultationCreateHandler(
            $this->validateConstraints,
            $this->medicalRecord,
            $this->userInterface,
            $this->consultationInterface,
        );

        $this->command = new ConsultationCreate(
            123,
            123,
            222,
            new \DateTime("25-02-2015"),
            new \DateTime("25-02-2015"),
            "notes"
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

        $medicalRecord = new MedicalRecord();
        $medicalRecord->setPatient($doctor);
        $this->medicalRecord
            ->expects($this->once())
            ->method('findById')
            ->with(222)
            ->willReturn($medicalRecord);

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

        $medicalRecord = new MedicalRecord();
        $medicalRecord->setPatient($doctor);
        $this->medicalRecord
            ->expects($this->once())
            ->method('findById')
            ->with(222)
            ->willReturn($medicalRecord);

        $this->consultationInterface
            ->expects($this->once())
            ->method('save')
            ->willThrowException(
                new \Exception('A ocurrido un error, intente de nuevo o hable con el adminstrador')
            );

        $this->expectException(\Exception::class);

        $this->handler->handle($this->command);
    }
}
